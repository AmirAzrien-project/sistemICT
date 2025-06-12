<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Roboto:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    @vite(['resources/css/home.css'])
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
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-johor dropdown-toggle" href="{{ route('permohonan.index') }}"
                            id="permohonanDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            PERMOHONAN
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="permohonanDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('permohonan.index') }}">PERMOHONAN</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('permohonan.senarai') }}">SENARAI</a>
                            </li>
                            @if (in_array(auth()->user()->type, [2, 3, 4]))
                                <li>
                                    <a class="dropdown-item" href="{{ route('pengurusan.index') }}">PENGURUSAN</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    @if (in_array(auth()->user()->type, [2, 3, 4]))
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-link-johor dropdown-toggle" href="{{ route('mesyuarat.index') }}"
                                id="mesyuaratDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                MESYUARAT
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="mesyuaratDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('mesyuarat.index') }}">MESYUARAT</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('mesyuarat.index') }}">PENGURUSAN</a>
                                </li>
                            </ul>
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

    <!-- Main Content -->
    <div class="container my-5">
        <div class="main-content">

            <!-- Include the Profile Partials -->
            <div class="profile-section profile-update-wrapper">
                @include('profile.partials.update-profile-information-form')

                <!-- Toast Notification at Top -->
                <div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1100;">
                    <div id="successToast" class="toast align-items-center text-white bg-success border-0"
                        role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                Maklumat anda telah berjaya dikemaskini
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-section password-update-wrapper">
                @include('profile.partials.update-password-form')
            </div>

            <div class="profile-section delete-user-wrapper">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer-johor">
        &copy; 2025 Sistem Kerajaan Johor. Hak cipta terpelihara.
    </footer>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var toastEl = document.getElementById('successToast');
                var toast = new bootstrap.Toast(toastEl);
                toast.show();
            });
        </script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
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
            setTimeout(hideLoadingOverlay, 1200); // Overlay kekal 1.2s selepas load
        });

        // Sembunyikan overlay bila kembali ke halaman melalui butang “Back” (cache aktif)
        window.addEventListener('pageshow', function(event) {
            if (event.persisted || performance.getEntriesByType("navigation")[0]?.type === "back_forward") {
                hideLoadingOverlay();
            }
        });
    </script>

</body>

</html>
