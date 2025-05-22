<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    // public function generatePdf(Request $request)
    // {
    //     // // Ambil semua input
    //     // $data = $request->only([
    //     //     'tajuk',
    //     //     'nama',
    //     //     'latar_belakang',
    //     //     'kekangan',
    //     //     'objektif',
    //     //     'justifikasi',
    //     //     'jumlah1',
    //     //     'jumlah2',
    //     //     'jumlah3',
    //     //     'jumlah_akhir',
    //     //     'nama_penyelaras',
    //     //     'jawatan',
    //     //     'gred_jawatan',
    //     //     'notel',
    //     //     'nofax',
    //     //     'email',
    //     //     'keputusan',
    //     // ]);

    //     $data = $request->all();
    //     // $pdf = Pdf::loadView('pdf.form-template', ['data' => $data]);
    //     $pdf = PDF::loadView('pdf.form-template', $data);

    //     // return $pdf->stream('form-template.pdf');

    //     return response($pdf->output(), 200)
    //         ->header('Content-Type', 'application/pdf')
    //         ->header('Content-Disposition', 'inline; filename="permohonan.pdf"');
    // }

    public function generatePdf(Request $request)
    {
        $data = $request->all();

        $keterangan = $request->input('keterangan', []);
        $jumlah = $request->input('jumlah', []);

        // Pastikan nilai kewangan adalah nombor (float), bukan array atau string
        $data['jumlah1'] = isset($data['jumlah1']) ? (float) $data['jumlah1'] : 0;
        $data['jumlah2'] = isset($data['jumlah2']) ? (float) $data['jumlah2'] : 0;
        $data['jumlah3'] = isset($data['jumlah3']) ? (float) $data['jumlah3'] : 0;
        $data['tajuk'] = $data['tajuk'] ?? '';
        $data['nama'] = $data['nama'] ?? '';
        $data['tajuk_latar_belakang'] = $data['tajuk_latar_belakang'] ?? '';
        $data['latar_belakang'] = $data['latar_belakang'] ?? '';
        $data['tajuk_kekangan'] = $data['tajuk_kekangan'] ?? '';
        // $data['kekangan'] = $data['kekangan'] ?? '';
        $data['tajuk_objektif'] = $data['tajuk_objektif'] ?? '';
        $data['objektif'] = $data['objektif'] ?? '';
        $data['tajuk_justifikasi'] = $data['tajuk_justifikasi'] ?? '';
        $data['justifikasi'] = $data['justifikasi'] ?? '';
        $data['nama_penyelaras'] = $data['nama_penyelaras'] ?? '';
        $data['jawatan'] = $data['jawatan'] ?? '';
        $data['gred_jawatan'] = $data['gred_jawatan'] ?? '';
        $data['notel'] = $data['notel'] ?? '';
        $data['nofax'] = $data['nofax'] ?? '';
        $data['email'] = $data['email'] ?? '';
        $data['keputusan'] = $data['keputusan'] ?? '';

        // Hasilkan PDF
        $pdf = PDF::loadView('pdf.form-template', $data);

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="permohonan.pdf"');
    }

    public function showForm()
    {
        return view('permohonan.tambah');  // View untuk form baru
    }
}
