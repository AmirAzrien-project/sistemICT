<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permohonan;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function dashboardUmum()
    {
        $id_pekerja = auth()->user()->id_pekerja;

        $statusCounts = Permohonan::where('id_pekerja', $id_pekerja)
            ->selectRaw('status_sekretariat, count(*) as count')
            ->groupBy('status_sekretariat')
            ->pluck('count', 'status_sekretariat')
            ->toArray();

        return view('dashboards.umum', [
            'title' => 'Utama - Pengguna Umum',
            'statusCounts' => $statusCounts,
        ]);
    }

    public function dashboardSekretariat()
    {
        $id_pekerja = auth()->user()->id_pekerja;

        // Kira jumlah permohonan mengikut status
        $statusCounts = Permohonan::where('id_pekerja', $id_pekerja)
            ->whereIn('status_sekretariat', ['Tidak Lengkap', 'Perlu Semakan Semula', 'Disyorkan'])
            ->selectRaw('status_sekretariat, count(*) as count')
            ->groupBy('status_sekretariat')
            ->pluck('count', 'status_sekretariat')
            ->toArray();

        return view('dashboards.sekretariat', [
            'title' => 'Utama - Sekretariat',
            'statusCounts' => $statusCounts,
        ]);
    }

    public function dashboardAdminJabatan()
    {
        $id_pekerja = auth()->user()->id_pekerja;

        // Kira jumlah permohonan mengikut status
        $statusCounts = Permohonan::where('id_pekerja', $id_pekerja)
            ->whereIn('status_sekretariat', ['Tidak Lengkap', 'Perlu Semakan Semula', 'Disyorkan'])
            ->selectRaw('status_sekretariat, count(*) as count')
            ->groupBy('status_sekretariat')
            ->pluck('count', 'status_sekretariat')
            ->toArray();

        return view('dashboards.adminjabatan', [
            'title' => 'Utama - Admin Jabatan',
            'statusCounts' => $statusCounts,
        ]);
    }

    public function dashboardSuperAdmin()
    {
        // Kira permohonan dengan status "Tidak Lengkap"
        $statusCounts = Permohonan::whereIn('status_sekretariat', ['Tidak Lengkap', 'Perlu Semakan Semula', 'Disyorkan'])
            ->selectRaw('status_sekretariat, count(*) as count')
            ->groupBy('status_sekretariat')
            ->pluck('count', 'status_sekretariat')
            ->toArray();

        return view('dashboards.superadmin', [
            'title' => 'Utama - Super Admin',
            'jumlah_pengguna' => User::where('type', 1)->count(),
            'jumlah_sekretariat' => User::where('type', 2)->count(),
            'jumlah_admin_jabatan' => User::where('type', 3)->count(),
            'jumlah_super_admin' => User::where('type', 4)->count(),
            'statusCounts' => $statusCounts, // Menambah statusCounts untuk diberikan pada view
        ]);
    }
}
