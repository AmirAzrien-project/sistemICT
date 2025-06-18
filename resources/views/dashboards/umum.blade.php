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
    @include('layouts.navigation')
    <div class="container">
        @yield('content')
    </div>

    <div class="container">
        <div class="row g-4">
            <!-- Maklumat Pengguna di kiri -->
            <div class="col-lg-6">
                <div class="user-info-card h-100">
                    <div class="user-info-header">
                        <h1 style="color: #ffffff">MAKLUMAT PENGGUNA</h1>
                        <p>Berikut adalah maklumat akaun anda seperti yang direkodkan dalam sistem.</p>
                    </div>
                    <div class="user-info-content">
                        <div class="info-row">
                            <div class="info-icon"><i class="bi bi-person-circle"></i></div>
                            <div class="info-label">Nama</div>
                            <div class="info-value">{{ Auth::user()->name }}</div>
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
                        @php
                            $jabatan = Auth::user()->jabatan ?? '-';
                            $jabatanFormatted = preg_replace('/,/', ',<br>', $jabatan, 1);
                        @endphp
                        <div class="info-row">
                            <div class="info-icon"><i class="bi bi-building"></i></div>
                            <div class="info-label">Jabatan</div>
                            <div class="info-value" style="overflow-wrap:break-word;word-break:break-word;min-width:0;">
                                {!! $jabatanFormatted !!}
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon"><i class="bi bi-envelope"></i></div>
                            <div class="info-label">Emel</div>
                            <div class="info-value">{{ Auth::user()->email }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon"><i class="bi bi-telephone"></i></div>
                            <div class="info-label">No. Telefon</div>
                            <div class="info-value">{{ Auth::user()->notel }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Bar di kanan -->
            <div class="col-lg-6">
                <div class="user-info-card h-100" style="font-size: 0.98rem;">
                    <div class="card-body py-3 px-4">
                        <div class="fw-semibold mb-3 text-primary" style="font-size:1.1em;">
                            <i class="bi bi-bell-fill me-1"></i> Notifikasi Permohonan
                        </div>
                        <div class="row text-center mb-3">
                            <div class="col-6 col-md-3 mb-2">
                                <div class="text-warning" style="font-size:2em;"><i class="bi bi-hourglass-split"></i>
                                </div>
                                <div class="fw-bold">{{ $statusCounts['Menunggu'] ?? 0 }}</div>
                                <div style="font-size:0.95em;">Menunggu</div>
                            </div>
                            <div class="col-6 col-md-3 mb-2">
                                <div class="text-primary" style="font-size:2em;"><i class="bi bi-star-fill"></i></div>
                                <div class="fw-bold">{{ $statusCounts['Disyorkan'] ?? 0 }}</div>
                                <div style="font-size:0.95em;">Disyorkan</div>
                            </div>
                            <div class="col-6 col-md-3 mb-2">
                                <div class="text-danger" style="font-size:2em;"><i class="bi bi-x-circle-fill"></i>
                                </div>
                                <div class="fw-bold">{{ $statusCounts['Tidak Disyorkan'] ?? 0 }}</div>
                                <div style="font-size:0.95em;">Tidak Disyorkan</div>
                            </div>
                            <div class="col-6 col-md-3 mb-2">
                                <div class="text-secondary" style="font-size:2em;"><i
                                        class="bi bi-exclamation-triangle-fill"></i>
                                </div>
                                <div class="fw-bold">{{ $statusCounts['Perlu Semakan Semula'] ?? 0 }}</div>
                                <div style="font-size:0.95em;">Perlu Semakan Semula</div>
                            </div>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <span class="text-muted" style="font-size:0.95em;">Jumlah Permohonan:</span>
                                <span class="fw-bold">{{ array_sum($statusCounts) }}</span>
                            </div>
                            <a href="{{ route('permohonan.senarai') }}" class="btn btn-link btn-sm text-decoration-none">
                                <i class="bi bi-list-ul"></i> Lihat Semua
                            </a>
                        </div>
                        @if (isset($lastPermohonanDate))
                            <div class="text-muted" style="font-size:0.93em;">
                                <i class="bi bi-clock-history me-1"></i>
                                Permohonan terakhir:
                                {{ \Carbon\Carbon::parse($lastPermohonanDate)->format('d/m/Y h:i A') }}
                            </div>
                        @endif

                        <!-- SENARAI PERMOHONAN MENGIKUT STATUS -->
                        <hr class="my-3">
                        <div>
                            @php
                                $statusList = [
                                    'Disyorkan' => ['color' => 'primary', 'icon' => 'star-fill'],
                                    'Menunggu' => ['color' => 'warning', 'icon' => 'hourglass-split'],
                                    'Tidak Disyorkan' => ['color' => 'danger', 'icon' => 'x-circle-fill'],
                                    'Perlu Semakan Semula' => [
                                        'color' => 'secondary',
                                        'icon' => 'exclamation-triangle-fill',
                                    ],
                                ];
                            @endphp

                            @foreach ($statusList as $status => $meta)
                                <div class="mb-2">
                                    <div class="d-flex align-items-center mb-1" style="font-size:1em;">
                                        <i class="bi bi-{{ $meta['icon'] }} text-{{ $meta['color'] }} me-2"></i>
                                        <span
                                            class="fw-semibold text-{{ $meta['color'] }}">{{ $status }}</span>
                                        <span class="badge bg-light text-dark ms-2" style="font-size:0.95em;">
                                            {{ isset($permohonanByStatus[$status]) ? count($permohonanByStatus[$status]) : 0 }}
                                        </span>
                                    </div>
                                    @if (isset($permohonanByStatus[$status]) && count($permohonanByStatus[$status]))
                                        <ul class="mb-1 ms-4 ps-0" style="list-style:none;">
                                            @foreach ($permohonanByStatus[$status] as $permohonan)
                                                <li class="text-truncate" style="max-width: 220px; font-size:0.97em;"
                                                    title="{{ $permohonan->tajuk }}">
                                                    <span class="text-muted me-1"
                                                        style="font-size:0.9em;">&#8226;</span>
                                                    {{ $permohonan->tajuk }}
                                                </li>
                                            @endforeach
                                        </ul>
                                        <br>
                                    @else
                                        <div class="text-muted ms-4" style="font-size:0.96em;">Tiada</div>
                                        <br>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
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
