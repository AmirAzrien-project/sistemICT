<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Roboto:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    @vite(['resources/css/home.css'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <!-- Loading Overlay -->
    <div id="loading-overlay">
        <div class="text-center">
            <div class="spinner-border text-primary" role="status"></div>
            <div class="loading-text">Memuatkan Sistem...</div>
        </div>
    </div>

    <!-- Header -->
    <nav class="navbar navbar-expand-lg johor-header shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="https://images.seeklogo.com/logo-png/30/1/kerajaan-negeri-johor-logo-png_seeklogo-306450.png"
                    alt="Jata Johor" class="johor-logo">
                <div>
                    <span class="d-block fw-bold">SISTEM PENTADBIRAN</span>
                    <small class="d-block text-muted">JOHOR DARUL TA'ZIM</small>
                </div>
            </a>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (auth()->user()->type == 1)
                        <li class="nav-item">
                            <a class="nav-link nav-link-johor" href="{{ route('dashboard.umum') }}">UTAMA</a>
                        </li>
                    @endif
                    @if (auth()->user()->type == 2)
                        <li class="nav-item">
                            <a class="nav-link nav-link-johor" href="{{ route('dashboard.sekretariat') }}">UTAMA</a>
                        </li>
                    @endif
                    @if (auth()->user()->type == 3)
                        <li class="nav-item">
                            <a class="nav-link nav-link-johor" href="{{ route('dashboard.adminjabatan') }}">UTAMA</a>
                        </li>
                    @endif
                    @if (auth()->user()->type == 4)
                        <li class="nav-item">
                            <a class="nav-link nav-link-johor" href="{{ route('dashboard.superadmin') }}">UTAMA</a>
                        </li>
                    @endif
                    @if (in_array(auth()->user()->type, [2, 3, 4]))
                        <li class="nav-item">
                            <a class="nav-link nav-link-johor" href="{{ route('pengguna') }}">PENGGUNA</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link nav-link-johor" href="{{ route('permohonan.index') }}">PERMOHONAN</a>
                    </li>
                    @if (in_array(auth()->user()->type, [2, 3, 4]))
                        <li class="nav-item">
                            <a class="nav-link nav-link-johor" href="{{ route('pengurusan.index') }}">PENGURUSAN</a>
                        </li>
                    @endif
                    @if (in_array(auth()->user()->type, [2, 3, 4]))
                        <li class="nav-item">
                            <a class="nav-link nav-link-johor" href="{{ route('mesyuarat.index') }}">MESYUARAT</a>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="dropdown">
                <button class="btn btn-johor dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">PROFIL</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">LOG KELUAR</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="container my-5">
        <div class="container">
            <h2 class="mb-4">Mesyuarat JPICT: {{ $permohonan->tajuk }}</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('mesyuarat.step1.submit', $permohonan->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nama_mesyuarat" class="form-label">Nama Mesyuarat</label>
                    <input type="text" name="nama_mesyuarat" id="nama_mesyuarat" class="form-control"
                        value="{{ old('nama_mesyuarat') }}" required>
                </div>

                <div class="mb-3">
                    <label for="nilai_projek" class="form-label">Nilai Projek (RM)</label>
                    <input type="number" name="nilai_projek" id="nilai_projek" class="form-control" step="0.01"
                        value="{{ old('nilai_projek') }}" required>
                </div>

                <div class="mb-3">
                    <label for="kelulusan" class="form-label">Keputusan Mesyuarat</label>
                    <select name="kelulusan" id="kelulusan" class="form-select" required>
                        <option value="">-- Sila Pilih --</option>
                        <option value="Disyorkan" {{ old('Disyorkan') == 'Disyorkan' ? 'selected' : '' }}>Disyorkan
                        </option>
                        <option value="Lulus" {{ old('kelulusan') == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                        <option value="Tidak Lulus" {{ old('kelulusan') == 'Tidak Lulus' ? 'selected' : '' }}>Tidak
                            Lulus</option>
                        <option value="Ditangguh" {{ old('kelulusan') == 'Ditangguh' ? 'selected' : '' }}>Ditangguh
                        </option>
                        <option value="Perlu Semakan Semula"
                            {{ old('Perlu Semakan Semula') == 'Perlu Semakan Semula' ? 'selected' : '' }}>Perlu Semakan
                            Semula
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tarikh_masa" class="form-label">Tarikh & Masa Mesyuarat</label>
                    <input type="datetime-local" name="tarikh_masa" id="tarikh_masa" class="form-control"
                        value="{{ old('tarikh_masa') }}" required>
                </div>

                <button type="submit" class="btn btn-success">Simpan Mesyuarat</button>
                <a href="{{ route('mesyuarat.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer-johor">
        &copy; 2025 Sistem Kerajaan Johor. Hak Cipta Terpelihara.
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function hideLoadingOverlay() {
            const overlay = document.getElementById('loading-overlay');
            if (overlay) {
                overlay.style.opacity = 0;
                setTimeout(() => {
                    overlay.style.display = 'none';
                }, 400);
            }
        }

        // Tunjukkan overlay semasa keluar dari halaman
        window.addEventListener('beforeunload', function() {
            const overlay = document.getElementById('loading-overlay');
            if (overlay) {
                overlay.style.display = 'flex';
                overlay.style.opacity = 1;
            }
        });

        // Sembunyikan overlay selepas halaman siap dimuat (normal load)
        window.addEventListener('load', function() {
            setTimeout(hideLoadingOverlay, 800); // Overlay kekal 1.2s selepas load
        });

        // Sembunyikan overlay bila kembali ke halaman melalui butang “Back” (cache aktif)
        window.addEventListener('pageshow', function(event) {
            if (event.persisted || performance.getEntriesByType("navigation")[0]?.type === "back_forward") {
                hideLoadingOverlay();
            }
        });
    </script>

    <script>
        // SEMAK & SEMBUNYIKAN RUANGAN KEMASKINI SELEPAS RELOAD
        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('hideUpdateSection') === 'true') {
                const updateSection = document.getElementById(
                    'updateSection'); // Ganti dengan ID sebenar ruangan kemaskini
                if (updateSection) {
                    updateSection.style.display = 'none'; // atau guna .classList.add('d-none')
                }
                localStorage.removeItem('hideUpdateSection');
            }
        });

        // HANTAR BORANG PERMOHONAN
        document.getElementById('permohonanForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const skop = document.getElementById('skop');
            const tajuk = document.getElementById('tajuk');

            // Buang gaya error lama
            skop.classList.remove('is-invalid');
            tajuk.classList.remove('is-invalid');

            let hasError = false;
            let errorMessages = [];

            // Validasi
            if (!skop.value) {
                skop.classList.add('is-invalid');
                errorMessages.push('Sila pilih Skop Projek.');
                hasError = true;
            }

            if (!tajuk.value.trim()) {
                tajuk.classList.add('is-invalid');
                errorMessages.push('Sila isi Tajuk Permohonan.');
                hasError = true;
            }

            if (hasError) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Maklumat Tidak Lengkap!',
                    html: errorMessages.join('<br>'),
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc3545',
                    background: '#fff3cd',
                    iconColor: '#ffc107',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
                return;
            }

            const formData = new FormData(this);

            try {
                const response = await fetch("{{ route('permohonan.store') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                    },
                    body: formData
                });

                const contentType = response.headers.get("content-type");

                if (contentType && contentType.includes("application/json")) {
                    const result = await response.json();

                    if (result && result.message) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Permohonan Berjaya!',
                            text: result.message,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#003366',
                            background: '#fff9f0',
                            iconColor: '#4BB543',
                            showClass: {
                                popup: 'animate__animated animate__fadeInUp'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutDown'
                            }
                        }).then(() => {
                            localStorage.setItem('hideUpdateSection', 'true'); // Simpan flag
                            location.reload();
                        });

                        this.reset();
                    } else {
                        throw new Error('Maklum balas tidak sah.');
                    }
                } else {
                    throw new Error('Maklum balas bukan JSON.');
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ralat!',
                    text: `Permohonan gagal dihantar. Sila cuba lagi. Ralat: ${error.message}`,
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#dc3545',
                    background: '#f8d7da',
                    iconColor: '#dc3545',
                    showClass: {
                        popup: 'animate__animated animate__fadeInUp'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutDown'
                    }
                });
            }
        });
    </script>

</body>

</html>
