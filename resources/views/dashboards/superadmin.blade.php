<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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
                            <a class="nav-link nav-link-johor active"
                                href="{{ route('dashboard.superadmin') }}">UTAMA</a>
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

    {{-- Notification Permohonan --}}
    @php
        $jumlahPerluSemak = $statusCounts['Perlu Semakan Semula'] ?? 0;
        $jumlahTidakLengkap = $statusCounts['Tidak Lengkap'] ?? 0;
    @endphp
    @if ($jumlahPerluSemak > 0 || $jumlahTidakLengkap > 0)
        <div class="alert alert-info alert-dismissible fade show d-flex align-items-center" role="alert"
            data-bs-toggle="collapse" href="#multipleNotifications" aria-expanded="false"
            aria-controls="multipleNotifications">
            <i class="bi bi-info-circle-fill me-2"></i>
            <div>
                <strong>Notifikasi Permohonan</strong>
                <span>Anda mempunyai permohonan yang memerlukan tindakan lanjut. Sila tekan bar ini untuk melihat
                    butiran.</span>
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @else
        <div class="alert alert-info alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i>
            <div>
                <strong>Notifikasi Permohonan</strong>
                <span>Tiada notifikasi buat masa ini.</span>
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <div id="multipleNotifications" class="collapse">
        @foreach ($statusCounts as $status => $count)
            @if ($count > 0)
                @switch($status)
                    @case('Tidak Lengkap')
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div>
                                <strong>Perhatian!</strong> Anda mempunyai {{ $count }} permohonan berstatus
                                <strong>"Tidak Lengkap"</strong>.
                                <a href="{{ route('permohonan.index') }}" class="alert-link">Klik untuk semak</a>.
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                aria-label="Tutup"></button>
                        </div>
                    @break

                    @case('Perlu Semakan Semula')
                        <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                            <div>
                                <strong>Amaran!</strong> Anda mempunyai {{ $count }} permohonan berstatus
                                <strong>"Perlu Semakan Semula"</strong>.
                                <a href="{{ route('permohonan.index') }}" class="alert-link">Klik untuk semak</a>.
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                aria-label="Tutup"></button>
                        </div>
                    @break

                    @case('Disyorkan')
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div>
                                <strong>Makluman!</strong> Anda mempunyai {{ $count }} permohonan berstatus
                                <strong>"Disyorkan"</strong>.
                                <a href="{{ route('permohonan.index') }}" class="alert-link">Klik untuk semak</a>.
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                aria-label="Tutup"></button>
                        </div>
                    @break
                @endswitch
            @endif
        @endforeach

        {{-- Butang Lihat Semua jika ada sebarang status
        @if (collect($statusCounts)->sum() > 0)
            <div class="text-center mt-3">
                <a href="{{ route('permohonan.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-list-check me-1"></i> Lihat Semua Permohonan
                </a>
            </div>
        @endif --}}
    </div>

    <!-- Main Content -->
    <div class="user-info-card">
        <div class="user-info-header">
            <h1 style="color: #ffffff">MAKLUMAT PENGGUNA</h1>
            <p>Berikut adalah maklumat akaun anda seperti yang direkodkan dalam sistem.</p>
        </div>

        <div class="user-info-content">
            @php
                $userTypes = [
                    1 => ['label' => 'Pengguna Biasa', 'class' => 'user-badge badge-pengguna-biasa'],
                    2 => ['label' => 'Sekretariat', 'class' => 'user-badge badge-sekretariat'],
                    3 => ['label' => 'Admin Jabatan', 'class' => 'user-badge badge-admin-jabatan'],
                    4 => ['label' => 'Super Admin', 'class' => 'user-badge badge-super-admin'],
                ];
                $type = Auth::user()->type;
                $userType = $userTypes[$type] ?? [
                    'label' => 'Tidak Diketahui',
                    'class' => 'user-badge badge-tidak-diketahui',
                ];
            @endphp

            <div class="info-row">
                <div class="info-icon"><i class="bi bi-person-badge"></i></div>
                <div class="info-label">Jenis Pengguna</div>
                <div class="info-value"><span style="color: white"
                        class="{{ $userType['class'] }}">{{ $userType['label'] }}</span></div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class="bi bi-card-text"></i></div>
                <div class="info-label">ID Pekerja</div>
                <div class="info-value">{{ Auth::user()->id_pekerja }}</div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class="bi bi-briefcase"></i></div>
                <div class="info-label">Jawatan</div>
                <div class="info-value">{{ Auth::user()->jawatan ?? '-' }}</div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class="bi bi-person-circle"></i></div>
                <div class="info-label">Nama</div>
                <div class="info-value">{{ Auth::user()->name }}</div>
            </div>

            <div class="info-row">
                <div class="info-icon"><i class="bi bi-envelope"></i></div>
                <div class="info-label">Emel</div>
                <div class="info-value">{{ Auth::user()->email }}</div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer-johor">
        &copy; 2025 Sistem Kerajaan Johor. Hak cipta terpelihara.
    </footer>

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

        window.addEventListener('beforeunload', function() {
            const overlay = document.getElementById('loading-overlay');
            if (overlay) {
                overlay.style.display = 'flex';
                overlay.style.opacity = 1;
            }
        });

        window.addEventListener('load', function() {
            setTimeout(hideLoadingOverlay, 800);
        });

        window.addEventListener('pageshow', function(event) {
            if (event.persisted || performance.getEntriesByType("navigation")[0]?.type === "back_forward") {
                hideLoadingOverlay();
            }
        });
    </script>
</body>

</html>
