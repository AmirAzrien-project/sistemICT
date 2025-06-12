<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\PengurusanController;
use App\Http\Controllers\MesyuaratController;
use App\Http\Controllers\PdfController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('auth/login');
// });

Route::get('/', function () {
    return view('welcome');
});

// Email verification routes (Laravel default)
Auth::routes(['verify' => true]);

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('login', [AuthenticatedSessionController::class, 'customLogin']);
Route::post('/logout', function () {
    Artisan::call('cache:clear');
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Semua route utama perlu email verified!
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pengguna
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna');
    Route::get('/pengguna/create', [PenggunaController::class, 'create'])->name('pengguna.create');
    Route::post('/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::put('/pengguna/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');

    // Permohonan
    Route::get('/permohonan', [PermohonanController::class, 'index'])->name('permohonan.index');
    Route::get('/permohonan/senarai', [PermohonanController::class, 'senarai'])->name('permohonan.senarai');
    Route::post('/permohonan', [PermohonanController::class, 'store'])->name('permohonan.store');
    Route::get('/permohonan/tambah', [PdfController::class, 'showForm'])->name('permohonan.tambah');
    Route::post('/permohonan/tambah', [PdfController::class, 'generatePdf'])->name('permohonan.generatePdf');
    Route::get('/permohonan/edit/{id}', [PermohonanController::class, 'showUpdateForm'])->name('permohonan.showUpdateForm');
    Route::get('/permohonan/{id}/edit', [PermohonanController::class, 'edit'])->name('permohonan.edit');
    Route::put('/permohonan/update/{id}', [PermohonanController::class, 'update'])->name('permohonan.update');

    // Pengurusan
    Route::get('/pengurusan', [PengurusanController::class, 'index'])->name('pengurusan.index');

    // Mesyuarat
    Route::get('/mesyuarat', [MesyuaratController::class, 'index'])->name('mesyuarat.index');
    Route::post('/mesyuarat/simpan', [MesyuaratController::class, 'store'])->name('mesyuarat.store');
    Route::get('/mesyuarat/{permohonan_id}/{peringkat_mesyuarat}/edit', [MesyuaratController::class, 'edit'])->name('mesyuarat.edit');

    // Dashboard Redirector
    Route::get('/dashboard', function () {
        return match (auth()->user()->type) {
            1 => redirect()->route('dashboard.umum'),
            2 => redirect()->route('dashboard.sekretariat'),
            3 => redirect()->route('dashboard.adminjabatan'),
            4 => redirect()->route('dashboard.superadmin'),
            default => abort(403, 'Akses tidak dibenarkan')
        };
    })->name('dashboard');

    // General User (Type 1)
    Route::middleware('penggunaUmum')->group(function () {
        Route::get('/dashboard/umum', [DashboardController::class, 'dashboardUmum'])->name('dashboard.umum');
    });

    // Sekretariat (Type 2)
    Route::middleware('sekretariat')->prefix('sekretariat')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboardSekretariat'])->name('dashboard.sekretariat');
    });

    // Admin Jabatan (Type 3)
    Route::middleware('adminJabatan')->prefix('admin-jabatan')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboardAdminJabatan'])->name('dashboard.adminjabatan');
    });

    // Super Admin (Type 4)
    Route::middleware('superAdmin')->prefix('super-admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboardSuperAdmin'])->name('dashboard.superadmin');
    });

    // Admin Jabatan & Super Admin
    Route::middleware('adminJabatanOrSuperAdmin')->prefix('pengurusan')->group(function () {
        Route::get('/', [PengurusanController::class, 'index'])->name('pengurusan.index');
        Route::get('/permohonan/{id}', [PengurusanController::class, 'show'])->name('pengurusan.show');
        Route::post('/permohonan/{id}/status', [PengurusanController::class, 'updateStatus'])->name('pengurusan.updateStatus');

        Route::get('/mesyuarat', [MesyuaratController::class, 'index'])->name('mesyuarat.index');
        Route::post('/mesyuarat/simpan', [MesyuaratController::class, 'store'])->name('mesyuarat.store');
        Route::get('/mesyuarat/{permohonan_id}/{peringkat_mesyuarat}/edit', [MesyuaratController::class, 'edit'])->name('mesyuarat.edit');
    });
});

// Health check
Route::get('/health', \Spatie\Health\Http\Controllers\HealthCheckResultsController::class);

require __DIR__ . '/auth.php';
