<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Permohonan;

class PermohonanController extends Controller
{
    public function index()
    {
        $permohonans = Permohonan::where('id_pekerja', auth()->user()->id_pekerja)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('permohonan.index', compact('permohonans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'notel' => 'required|string|max:15',
            'tajuk' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'skop' => 'required|string|max:1000',
            'dokumen1' => 'required|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'dokumen2' => 'required|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'dokumen3' => 'required|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'dokumen4' => 'required|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'dokumen5' => 'required|mimes:pdf,doc,docx,xls,xlsx|max:5120',
        ]);

        $user = auth()->user();

        // Simpan dokumen
        $dokumenPaths = [];
        for ($i = 1; $i <= 5; $i++) {
            $file = $request->file("dokumen{$i}");
            $filename = 'dokumen_' . $user->id_pekerja . '_' . time() . "_{$i}." . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/dokumen', $filename);
            $dokumenPaths["dokumen{$i}"] = $filename; // hanya simpan nama fail
        }

        $noRujukan = Permohonan::generateNoRujukan($request->skop, $user);
        $permohonan = new Permohonan();
        $permohonan->fill([
            'no_rujukan' => $noRujukan,
            'name' => $user->name,
            'notel' => $user->notel,
            'id_pekerja' => $user->id_pekerja,
            'jabatan' => $user->jabatan,
            'skop' => $request->skop,
            'tajuk' => $request->tajuk,
            'keterangan' => $request->keterangan,
            'status_sekretariat' => 'Menunggu',
        ]);
        
        $permohonan->fill($dokumenPaths); // masukkan dokumen1-5
        $permohonan->save();

        return response()->json([
            'message' => 'Permohonan berjaya dihantar!',
            'data' => $permohonan,
        ], 201);
    }

    public function showUpdateForm($id)
    {
        $selectedPermohonan = Permohonan::findOrFail($id);
        $permohonans = Permohonan::where('id_pekerja', auth()->user()->id_pekerja)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('permohonan.index', compact('selectedPermohonan', 'permohonans'));
    }


    public function update(Request $request, $id)
    {
        $permohonan = Permohonan::findOrFail($id);

        if ($permohonan->id_pekerja !== auth()->user()->id_pekerja) {
            abort(403, 'Akses tidak dibenarkan.');
        }

        $request->validate([
            'notel' => 'required|string|max:15',
            'tajuk' => 'required|string|max:255',
            'keterangan' => 'required|string|max:1000',
            'dokumen1' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,csv|max:5120',
            'dokumen2' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,csv|max:5120',
            'dokumen3' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,csv|max:5120',
            'dokumen4' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,csv|max:5120',
            'dokumen5' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,csv|max:5120',
        ]);

        $permohonan->update([
            'notel' => $request->notel,
            'tajuk' => $request->tajuk,
            'keterangan' => $request->keterangan,
            'status_sekretariat' => 'Telah Dikemaskini',
        ]);

        for ($i = 1; $i <= 5; $i++) {
            $fileInput = 'dokumen' . $i;
            if ($request->hasFile($fileInput)) {
                // Padam fail lama jika wujud
                $lama = $permohonan->$fileInput;
                if ($lama && Storage::disk('public')->exists('dokumen/' . $lama)) {
                    Storage::disk('public')->delete('dokumen/' . $lama);
                }

                $file = $request->file($fileInput);
                // $namaFail = time() . "_dokumen{$i}_" . $file->getClientOriginalName();
                $namaFail = 'dokumen_' . auth()->user()->id_pekerja . '_' . time() . "_{$i}." . $file->getClientOriginalExtension();
                $file->storeAs('dokumen', $namaFail, 'public');

                $permohonan->$fileInput = $namaFail;
            }
        }

        // $permohonan->save();

        return redirect()->route('permohonan.index')->with('success', 'Permohonan telah dikemaskini.');
    }
}
