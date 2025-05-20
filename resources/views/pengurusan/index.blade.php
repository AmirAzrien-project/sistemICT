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
                            <a class="nav-link nav-link-johor active"
                                href="{{ route('pengurusan.index') }}">PENGURUSAN</a>
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
    <div class="">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="main-container shadow-sm rounded-4 p-4 bg-white" style="width: 95%; margin: 0 auto;">
            <h2 class="mb-4 text-primary fw-bold">Pengurusan Permohonan</h2>

            <!-- Improved Filter and Search Form -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body py-4">
                    <form method="GET" action="{{ route('pengurusan.index') }}" class="row g-3 align-items-end">

                        <!-- Search Input -->
                        <div class="col-12 col-md-4">
                            <label for="search" class="form-label fw-semibold">Carian</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" id="search" class="form-control"
                                    placeholder="Carian..." value="{{ $search }}" style="height: 3.125rem">
                            </div>
                        </div>

                        <!-- Date Filter -->
                        <div class="col-12 col-md-3">
                            <label for="filter_date" class="form-label fw-semibold">Tarikh</label>
                            <input type="date" name="filter_date" id="filter_date" class="form-control"
                                value="{{ request('filter_date') }}">
                        </div>

                        <!-- Skop Projek Filter -->
                        <div class="col-12 col-md-3">
                            <label for="filter_skop" class="form-label fw-semibold">Skop Projek</label>
                            <select style="width: 85%" name="filter_skop" id="filter_skop" class="form-select">
                                <option value="" disabled selected>-- Pilih Skop --</option>
                                <option value="Pembangunan Sistem"
                                    {{ request('filter_skop') == 'Pembangunan Sistem' ? 'selected' : '' }}>Pembangunan
                                    Sistem</option>
                                <option value="Perkakasan ICT"
                                    {{ request('filter_skop') == 'Perkakasan ICT' ? 'selected' : '' }}>Perkakasan ICT
                                </option>
                                <option value="Perisian" {{ request('filter_skop') == 'Perisian' ? 'selected' : '' }}>
                                    Perisian</option>
                                <option value="Rangkaian dan Alatan Rangkaian"
                                    {{ request('filter_skop') == 'Rangkaian dan Alatan Rangkaian' ? 'selected' : '' }}>
                                    Rangkaian & Alatan Rangkaian</option>
                                <option value="Perkhidmatan ICT"
                                    {{ request('filter_skop') == 'Perkhidmatan ICT' ? 'selected' : '' }}>Perkhidmatan
                                    ICT</option>
                                <option value="Pengkomputeran Awan"
                                    {{ request('filter_skop') == 'Pengkomputeran Awan' ? 'selected' : '' }}>
                                    Pengkomputeran Awan</option>
                                <option value="Lain-lain"
                                    {{ request('filter_skop') == 'Lain-lain' ? 'selected' : '' }}>Lain-lain
                                </option>
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-12 col-md-2 d-flex gap-2">
                            <button type="submit"
                                class="btn btn-primary w-auto fw-semibold d-flex align-items-center justify-content-center">
                                <i class="bi bi-search me-2"></i> Cari
                            </button>
                            <a href="{{ route('pengurusan.index') }}"
                                class="btn btn-outline-secondary w-auto d-flex align-items-center justify-content-center"
                                title="Reset Filter">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Bil</th>
                            <th>Tarikh</th>
                            <th>Skop Projek</th>
                            <th>Nama Projek</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permohonan as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                <td>{{ $item->skop }}</td>
                                <td style="text-align: left">{{ $item->tajuk }}</td>
                                <td>{{ $item->jabatan }}</td>
                                <td>
                                    @php
                                        $status = $item->status_sekretariat;
                                        $badgeClass = match ($status) {
                                            'Menunggu' => 'secondary',
                                            'Lengkap' => 'success',
                                            'Tidak Lengkap' => 'danger',
                                            'Perlu Semakan Semula' => 'warning',
                                            'Disyorkan' => 'info',
                                            'Telah Dikemaskini' => 'primary',
                                            default => 'dark',
                                        };
                                    @endphp

                                    <span class="badge bg-{{ $badgeClass }}">
                                        {{ $status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ url('/pengurusan/permohonan/' . $item->id) }}"
                                        class="btn btn-primary btn-sm">Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
                    <div class="text-muted">
                        Menunjukkan {{ $permohonan->firstItem() }} - {{ $permohonan->lastItem() }} daripada
                        {{ $permohonan->total() }}
                        rekod
                    </div>
                    <div class="d-flex gap-2">
                        {{-- Previous --}}
                        @if ($permohonan->onFirstPage())
                            <span class="btn btn-outline-secondary disabled">
                                <i class="fas fa-chevron-left me-2"></i>Sebelumnya
                            </span>
                        @else
                            <a href="{{ $permohonan->previousPageUrl() }}" class="btn btn-outline-primary">
                                <i class="fas fa-chevron-left me-2"></i>Sebelumnya
                            </a>
                        @endif

                        {{-- Next --}}
                        @if ($permohonan->hasMorePages())
                            <a href="{{ $permohonan->nextPageUrl() }}" class="btn btn-outline-primary">
                                Seterusnya <i class="fas fa-chevron-right ms-2"></i>
                            </a>
                        @else
                            <span class="btn btn-outline-secondary disabled">
                                Seterusnya <i class="fas fa-chevron-right ms-2"></i>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer-johor mt-auto">
        &copy; 2025 Sistem Kerajaan Johor. Hak Cipta Terpelihara.
    </footer>

    <!-- Bootstrap JS -->
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
            setTimeout(hideLoadingOverlay, 800); // Overlay kekal 1.2s selepas load
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
