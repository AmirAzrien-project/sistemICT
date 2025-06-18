<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Mesyuarat;
use App\Models\Permohonan;

class MesyuaratController extends Controller
{
    public function index(Request $request)
    {
        $permohonans = DB::table('permohonan')
            ->whereRaw("LOWER(TRIM(status_sekretariat)) = 'disyorkan'");

        // Filter Nama Mesyuarat
        if ($request->search_nama) {
            $permohonans->where('tajuk', 'like', '%' . $request->search_nama . '%');
        }

        // Filter Jabatan
        if ($request->search_jabatan) {
            $permohonans->where('jabatan', 'like', '%' . $request->search_jabatan . '%');
        }

        // **Sort by created_at DESC (latest first)**
        $permohonans->orderBy('created_at', 'desc');

        // Ambil semua data dahulu
        $permohonans = $permohonans->get();

        // Tambah info mesy1_selesai & status_lulus
        foreach ($permohonans as $p) {
            $mesy1 = DB::table('mesyuarat')
                ->where('permohonan_id', $p->id)
                ->where('peringkat_mesyuarat', 1)
                ->whereIn('keputusan', ['Disyorkan'])
                ->first();

            $p->mesy1_selesai = $mesy1 ? true : false;

            $mesy2 = DB::table('mesyuarat')
                ->where('permohonan_id', $p->id)
                ->where('peringkat_mesyuarat', 2)
                ->where('keputusan', 'Lulus')
                ->whereNotNull('no_sijil')
                ->where('no_sijil', '!=', '')
                ->first();

            $p->status_lulus = $mesy2 ? 'Lulus' : '';
        }

        // Sorting by status (collection)
        if ($request->sort_status == 'lulus') {
            $permohonans = $permohonans->sortByDesc(function ($item) {
                return $item->status_lulus == 'Lulus' ? 1 : 0;
            })->values();
        } elseif ($request->sort_status == 'belum') {
            $permohonans = $permohonans->sortBy(function ($item) {
                return $item->status_lulus == 'Lulus' ? 1 : 0;
            })->values();
        }

        // Manual pagination
        $page = $request->get('page', 1);
        $perPage = 10;
        $total = $permohonans->count();
        $results = $permohonans->slice(($page - 1) * $perPage, $perPage)->values();

        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $results,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('mesyuarat.index', ['permohonans' => $paginated]);
    }


    // Function Store Mesyuarat
    public function store(Request $request)
    {
        $data = [
            'permohonan_id' => $request->permohonan_id,
            'no_rujukan' => $request->no_rujukan,
            'peringkat_mesyuarat' => $request->peringkat_mesyuarat,
            'tajuk' => $request->tajuk,
            'nilai_projek' => $request->nilai_projek,
            'keputusan' => $request->keputusan,
            'tarikh_masa' => $request->tarikh_masa,
        ];

        // For Mesyuarat 2, include no_sijil
        if ($request->peringkat_mesyuarat == 2 && $request->keputusan == 'Lulus') {
            $data['no_sijil'] = $this->generateNoSijil($request);
        }

        // Check if record already exists
        $existing = DB::table('mesyuarat')
            ->where('permohonan_id', $request->permohonan_id)
            ->where('peringkat_mesyuarat', $request->peringkat_mesyuarat)
            ->first();

        if ($existing) {
            // Update existing record
            DB::table('mesyuarat')
                ->where('id', $existing->id)
                ->update($data);

            $peringkat = $request->peringkat_mesyuarat == 1 ? 'Pertama' : 'Kedua';
            $tarikh = $existing->tarikh_masa
                ? date('d/m/Y H:i', strtotime($existing->tarikh_masa))
                : '-';

            // Gabung mesej berjaya & makluman dalam satu session
            return redirect()->back()->with(
                'success',
                "Maklumat Mesyuarat berjaya disimpan. Makluman: Data terakhir dikemaskini pada $tarikh."
            );
        } else {
            // Insert new record
            DB::table('mesyuarat')->insert($data);
            return redirect()->back()->with('success', 'Maklumat mesyuarat telah disimpan.');
        }
    }


    // Function Edit Mesyuarat
    public function edit($permohonan_id, $peringkat_mesyuarat)
    {
        $permohonan = Permohonan::find($permohonan_id);

        if (!$permohonan) {
            abort(404, 'Permohonan tidak dijumpai.');
        }

        $mesyuarat = Mesyuarat::where('permohonan_id', $permohonan_id)
            ->where('peringkat_mesyuarat', $peringkat_mesyuarat)
            ->first();

        // Ambil nilai_projek dari mesyuarat 1 jika mesyuarat 2 dan tiada nilai_projek
        $nilai_projek_mesy1 = null;
        if ($peringkat_mesyuarat == 2) {
            $mesy1 = Mesyuarat::where('permohonan_id', $permohonan_id)
                ->where('peringkat_mesyuarat', 1)
                ->first();
            $nilai_projek_mesy1 = $mesy1 ? $mesy1->nilai_projek : null;
        }

        return view('mesyuarat.edit', compact('permohonan', 'mesyuarat', 'peringkat_mesyuarat', 'nilai_projek_mesy1'));
    }


    // Generate No Sijil
    protected function generateNoSijil(Request $request)
    {
        $tahun = date('Y'); // tahun semasa

        // Contoh: dapatkan bilangan mesyuarat 2 tahun ni dari DB (bil-tahun)
        $bilTahunan = DB::table('mesyuarat')
            ->where('peringkat_mesyuarat', 2)
            ->whereYear('tarikh_masa', $tahun)
            ->count() + 1;

        // Skop dari permohonan (anda perlu sesuaikan ikut data permohonan)
        $permohonan = Permohonan::find($request->permohonan_id);
        $skop = $permohonan ? $permohonan->skop : 'SKOP'; // gantikan 'skop' ikut nama kolum sebenar

        // Format no sijil
        $noSijil = sprintf(
            "%s/JPICT(%02d-%s)/%s/%03d",
            $tahun,
            $bilTahunan,
            $tahun,
            strtoupper(str_replace(' ', '', $skop)),
            $bilTahunan
        );

        return $noSijil;
    }
}
