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
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-johor dropdown-toggle active" href="{{ route('permohonan.index') }}"
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

    <!-- Main content -->
    <main class="container my-5">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berjaya!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Applications List Card -->
        <div class="card shadow-sm rounded-4 p-4">
            <h4 class="mb-4 fw-bold" style="color: #003366;">Senarai Permohonan Saya</h4>

            <div class="table-responsive rounded-3">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th scope="col" style="width: 180px;">Tarikh</th>
                            <th scope="col">Skop Projek</th>
                            <th scope="col">Nama Projek</th>
                            <th scope="col" style="width: 140px;">Status</th>
                            <th scope="col" style="width: 120px;">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permohonans as $permohonan)
                            <tr>
                                <td class="text-center">{{ $permohonan->created_at->format('d/m/Y') }}</td>
                                <td style="text-align: ">{{ $permohonan->skop }}</td>
                                <td style="text-align: left">{{ $permohonan->tajuk }}</td>
                                <td class="text-center">
                                    @php
                                        $status = $permohonan->status_sekretariat ?? 'Dalam Proses';

                                        // Define badge classes and icons for each status
                                        $statusMap = [
                                            'Lengkap' => [
                                                'class' => 'bg-success text-white',
                                                'icon' => 'check-circle-fill',
                                            ],
                                            'Tidak Lengkap' => [
                                                'class' => 'bg-danger text-white',
                                                'icon' => 'x-circle-fill',
                                            ],
                                            'Perlu Semakan Semula' => [
                                                'class' => 'bg-secondary text-white',
                                                'icon' => 'exclamation-triangle-fill',
                                            ],
                                            'Disyorkan' => [
                                                'class' => 'bg-primary text-white',
                                                'icon' => 'star-fill',
                                            ],
                                            'Menunggu' => [
                                                'class' => 'bg-light text-dark',
                                                'icon' => 'hourglass-split',
                                            ],
                                            'Telah Dikemaskini' => [
                                                'class' => 'bg-info text-white',
                                                'icon' => 'arrow-clockwise',
                                            ],
                                            'Selesai' => [
                                                'class' => 'bg-success text-white',
                                                'icon' => 'award-fill',
                                            ],
                                        ];

                                        // Fallback if status not in map
                                        $badgeClass = $statusMap[$status]['class'] ?? 'bg-light text-dark';
                                        $icon = $statusMap[$status]['icon'] ?? 'question-circle-fill';
                                    @endphp

                                    <span
                                        class="badge {{ $badgeClass }} px-3 py-2 fs-6 d-inline-flex align-items-center gap-1 shadow-sm"
                                        style="border-radius: 0.4rem; font-weight: 500; letter-spacing: 0.5px;"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ $status }}">
                                        <i class="bi bi-{{ $icon }}" aria-hidden="true"></i>
                                        {{ $status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button"
                                            class="btn btn-info btn-sm d-flex align-items-center gap-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#keteranganModal{{ $permohonan->id }}"
                                            aria-label="Lihat keterangan permohonan">
                                            <i class="bi bi-eye"></i> Lihat
                                        </button>

                                        <a href="{{ route('permohonan.edit', $permohonan->id) }}"
                                            class="btn btn-warning btn-sm d-flex align-items-center gap-1">
                                            <i class="bi bi-pencil-square"></i> Kemaskini
                                        </a>

                                    </div>
                                </td>

                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="keteranganModal{{ $permohonan->id }}" tabindex="-1"
                                aria-labelledby="keteranganModalLabel{{ $permohonan->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 shadow">
                                        <div class="modal-header bg-primary text-white rounded-top-4">
                                            <h5 class="modal-title" id="keteranganModalLabel{{ $permohonan->id }}">
                                                Keterangan Permohonan
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="mb-0">
                                                {{ $permohonan->keterangan ?? 'Tiada keterangan diberikan.' }}
                                            </p>

                                            <div class="mt-4">
                                                <strong class="fs-5 mb-2 d-block">Dokumen yang dimuat naik:</strong>
                                                <ul class="list-group">
                                                    @php
                                                        $dokumenNames = [
                                                            'Senarai Semak Permohonan Kelulusan Teknikal Projek Teknologi Maklumat dan Komunikasi (ICT) Kerajaan Negeri Johor',
                                                            'Borang Permohonan Kelulusan Teknikal Projek ICT',
                                                            'Cabutan Minit Mesyuarat JPICT Jabatan (berkenaan kelulusan permohonan projek)',
                                                            'Kertas Kerja Permohonan Kelulusan Teknikal Projek ICT',
                                                            'Slaid Permohonan Kelulusan Teknikal Projek ICT',
                                                        ];
                                                        $dokumenIcons = [
                                                            'bi bi-list-check', // Checklist icon
                                                            'bi bi-file-earmark-text', // Form icon
                                                            'bi bi-journal-text', // Minutes icon
                                                            'bi bi-file-earmark-richtext', // Paper icon
                                                            'bi bi-file-earmark-slides', // Slides icon
                                                        ];
                                                        $adaDokumen = false;
                                                    @endphp

                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @php
                                                            $dokumen = $permohonan->{'dokumen' . $i};
                                                        @endphp
                                                        @if ($dokumen)
                                                            @php $adaDokumen = true; @endphp
                                                            <li class="list-group-item d-flex align-items-center">
                                                                <i
                                                                    class="{{ $dokumenIcons[$i - 1] }} text-primary me-2 fs-5">
                                                                </i>
                                                                <a href="{{ asset('storage/dokumen/' . $dokumen) }}"
                                                                    target="_blank"
                                                                    class="flex-grow-1 text-decoration-none text-dark fw-semibold">
                                                                    {{ $dokumenNames[$i - 1] }}
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endfor

                                                    @unless ($adaDokumen)
                                                        <li class="list-group-item text-muted fst-italic">
                                                            <i class="bi bi-info-circle me-2"></i>
                                                            Tiada dokumen dimuat naik.
                                                        </li>
                                                    @endunless
                                                </ul>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted fst-italic py-4">
                                    Tiada permohonan direkodkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
                    <div class="text-muted">
                        Menunjukkan {{ $permohonans->firstItem() }} - {{ $permohonans->lastItem() }} daripada
                        {{ $permohonans->total() }} rekod
                    </div>
                    <div class="d-flex gap-2">
                        {{-- Previous --}}
                        @if ($permohonans->onFirstPage())
                            <span class="btn btn-outline-secondary disabled">
                                <i class="fas fa-chevron-left me-2"></i>Sebelumnya
                            </span>
                        @else
                            <a href="{{ $permohonans->previousPageUrl() }}" class="btn btn-outline-primary">
                                <i class="fas fa-chevron-left me-2"></i>Sebelumnya
                            </a>
                        @endif

                        {{-- Next --}}
                        @if ($permohonans->hasMorePages())
                            <a href="{{ $permohonans->nextPageUrl() }}" class="btn btn-outline-primary">
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
    </main>

    <!-- Footer -->
    <footer class="footer-johor mt-auto">
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

</body>

</html>
