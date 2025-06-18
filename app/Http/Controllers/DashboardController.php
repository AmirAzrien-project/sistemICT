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

        $statusList = ['Disyorkan', 'Menunggu', 'Tidak Disyorkan', 'Perlu Semakan Semula'];
        $permohonanByStatus = [];
        foreach ($statusList as $status) {
            $permohonanByStatus[$status] = Permohonan::where('id_pekerja', $id_pekerja)
                ->where('status_sekretariat', $status)
                ->orderByDesc('updated_at')
                ->take(6)
                ->get();
        }

        $lastPermohonanDate = Permohonan::where('id_pekerja', $id_pekerja)
            ->latest('created_at')->value('created_at');

        return view('dashboards.umum', [
            'title' => 'Utama - Pengguna Umum',
            'statusCounts' => $statusCounts,
            'permohonanByStatus' => $permohonanByStatus,
            'lastPermohonanDate' => $lastPermohonanDate,
        ]);
    }

    public function dashboardSekretariat()
    {
        $id_pekerja = auth()->user()->id_pekerja;

        $statusCounts = Permohonan::where('id_pekerja', $id_pekerja)
            ->whereIn('status_sekretariat', ['Tidak Lengkap', 'Perlu Semakan Semula', 'Disyorkan', 'Menunggu', 'Tidak Disyorkan'])
            ->selectRaw('status_sekretariat, count(*) as count')
            ->groupBy('status_sekretariat')
            ->pluck('count', 'status_sekretariat')
            ->toArray();

        $statusList = ['Disyorkan', 'Menunggu', 'Tidak Disyorkan', 'Perlu Semakan Semula'];
        $permohonanByStatus = [];
        foreach ($statusList as $status) {
            $permohonanByStatus[$status] = Permohonan::where('id_pekerja', $id_pekerja)
                ->where('status_sekretariat', $status)
                ->orderByDesc('updated_at') // Papar ikut latest updated
                ->take(6)
                ->get();
        }

        $lastPermohonanDate = Permohonan::where('id_pekerja', $id_pekerja)
            ->latest('created_at')->value('created_at');

        return view('dashboards.sekretariat', [
            'title' => 'Utama - Sekretariat',
            'statusCounts' => $statusCounts,
            'permohonanByStatus' => $permohonanByStatus,
            'lastPermohonanDate' => $lastPermohonanDate,
        ]);
    }

    public function dashboardAdminJabatan()
    {
        $id_pekerja = auth()->user()->id_pekerja;

        $statusCounts = Permohonan::where('id_pekerja', $id_pekerja)
            ->whereIn('status_sekretariat', ['Tidak Lengkap', 'Perlu Semakan Semula', 'Disyorkan'])
            ->selectRaw('status_sekretariat, count(*) as count')
            ->groupBy('status_sekretariat')
            ->pluck('count', 'status_sekretariat')
            ->toArray();

        $statusList = ['Disyorkan', 'Menunggu', 'Tidak Disyorkan', 'Perlu Semakan Semula'];
        $permohonanByStatus = [];
        foreach ($statusList as $status) {
            $permohonanByStatus[$status] = Permohonan::where('id_pekerja', $id_pekerja)
                ->where('status_sekretariat', $status)
                ->orderByDesc('updated_at')
                ->take(6)
                ->get();
        }

        $lastPermohonanDate = Permohonan::where('id_pekerja', $id_pekerja)
            ->latest('created_at')->value('created_at');

        return view('dashboards.adminjabatan', [
            'title' => 'Utama - Admin Jabatan',
            'statusCounts' => $statusCounts,
            'permohonanByStatus' => $permohonanByStatus,
            'lastPermohonanDate' => $lastPermohonanDate,
        ]);
    }

    public function dashboardSuperAdmin()
    {
        $statusCounts = Permohonan::whereIn('status_sekretariat', ['Tidak Lengkap', 'Perlu Semakan Semula', 'Disyorkan'])
            ->selectRaw('status_sekretariat, count(*) as count')
            ->groupBy('status_sekretariat')
            ->pluck('count', 'status_sekretariat')
            ->toArray();

        $statusList = ['Disyorkan', 'Menunggu', 'Tidak Disyorkan', 'Perlu Semakan Semula'];
        $permohonanByStatus = [];
        foreach ($statusList as $status) {
            $permohonanByStatus[$status] = Permohonan::where('status_sekretariat', $status)
                ->orderByDesc('updated_at')
                ->take(6)
                ->get();
        }

        $lastPermohonanDate = Permohonan::latest('created_at')->value('created_at');

        return view('dashboards.superadmin', [
            'title' => 'Utama - Super Admin',
            'jumlah_pengguna' => User::where('type', 1)->count(),
            'jumlah_sekretariat' => User::where('type', 2)->count(),
            'jumlah_admin_jabatan' => User::where('type', 3)->count(),
            'jumlah_super_admin' => User::where('type', 4)->count(),
            'statusCounts' => $statusCounts,
            'permohonanByStatus' => $permohonanByStatus,
            'lastPermohonanDate' => $lastPermohonanDate,
        ]);
    }
}
