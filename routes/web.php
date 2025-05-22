<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HubungiController;
use App\Http\Controllers\MaklumatController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\TetapanController;
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

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('login', [AuthenticatedSessionController::class, 'customLogin']);
Route::post('/logout', function () {
    Artisan::call('cache:clear');
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/hubungi-kami', [HubungiController::class, 'index'])->name('hubungi.kami');
    Route::get('/maklumat', [MaklumatController::class, 'index'])->name('maklumat');
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna');
    Route::get('/tetapan', [TetapanController::class, 'index'])->name('tetapan');

    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna');
    Route::get('/pengguna/create', [PenggunaController::class, 'create'])->name('pengguna.create');
    Route::post('/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::put('/pengguna/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');

    // GENERATE PDF
    Route::get('/permohonan/tambah', [PdfController::class, 'showForm'])->name('permohonan.tambah');
    Route::post('/permohonan/tambah', [PdfController::class, 'generatePdf'])->name('permohonan.generatePdf');

    Route::get('/permohonan', [PermohonanController::class, 'index'])->name('permohonan.index');
    Route::post('/permohonan', [PermohonanController::class, 'store'])->name('permohonan.store');
    Route::get('/permohonan/edit/{id}', [PermohonanController::class, 'showUpdateForm'])->name('permohonan.showUpdateForm');
    Route::get('/permohonan/{id}/edit', [PermohonanController::class, 'edit'])->name('permohonan.edit');
    Route::post('/permohonan/update/{id}', [PermohonanController::class, 'update'])->name('permohonan.update');

    Route::get('/pengurusan', [PengurusanController::class, 'index'])->name('pengurusan.index');
});

// Dashboard Redirector
Route::middleware('auth')->get('/dashboard', function () {
    return match (auth()->user()->type) {
        1 => redirect()->route('dashboard.umum'),
        2 => redirect()->route('dashboard.sekretariat'),
        3 => redirect()->route('dashboard.adminjabatan'),
        4 => redirect()->route('dashboard.superadmin'),
        default => abort(403, 'Akses tidak dibenarkan')
    };
})->name('dashboard');

// General User (Type 1)
Route::middleware(['auth', 'penggunaUmum'])->group(function () {
    Route::get('/dashboard/umum', [DashboardController::class, 'dashboardUmum'])->name('dashboard.umum');
});

// Sekretariat (Type 2)
Route::middleware(['auth', 'sekretariat'])->prefix('sekretariat')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboardSekretariat'])->name('dashboard.sekretariat');
});

// Admin Jabatan (Type 3)
Route::middleware(['auth', 'adminJabatan'])->prefix('admin-jabatan')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboardAdminJabatan'])->name('dashboard.adminjabatan');
});

// Super Admin (Type 4)
Route::middleware(['auth', 'superAdmin'])->prefix('super-admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboardSuperAdmin'])->name('dashboard.superadmin');
});

// Middleware for both Admins and Sekretariat
Route::middleware(['auth', 'adminJabatanOrSuperAdmin'])->prefix('pengurusan')->group(function () {
    Route::get('/', [PengurusanController::class, 'index'])->name('pengurusan.index');
    Route::get('/permohonan/{id}', [PengurusanController::class, 'show'])->name('pengurusan.show');
    Route::post('/permohonan/{id}/status', [PengurusanController::class, 'updateStatus'])->name('pengurusan.updateStatus');

    Route::get('/mesyuarat', [MesyuaratController::class, 'index'])->name('mesyuarat.index');
    Route::get('step1/{permohonan}', [MesyuaratController::class, 'showStep1Form'])->name('mesyuarat.step1');
    Route::post('step1/{permohonan}', [MesyuaratController::class, 'submitStep1'])->name('mesyuarat.step1.submit');
    Route::get('step2/{permohonan}', [MesyuaratController::class, 'showStep2Form'])->name('mesyuarat.step2');
    Route::post('step2/{permohonan}', [MesyuaratController::class, 'submitStep2'])->name('mesyuarat.step2.submit');
});



require __DIR__ . '/auth.php';
