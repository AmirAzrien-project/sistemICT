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
    @include('layouts.navigation')
    <div class="container">
        @yield('content')
    </div>

    <!-- Main Content -->
    <div class="">
        <div class="main-container shadow-sm rounded-4 p-4 bg-white"
            style="width: 85%; margin: 0 auto;margin-top:30px;margin-bottom:30px">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <h2 class="mb-4 text-primary fw-bold">Pengurusan Permohonan</h2>

            <!-- Improved Filter and Search Form -->
            <div class="card-body py-4">
                <form method="GET" action="{{ route('pengurusan.index') }}" class="row g-3 align-items-end">

                    <!-- Search Input -->
                    <div class="col-12 col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" id="search" class="form-control"
                                placeholder="Carian..." value="{{ $search }}" style="height: 3.125rem">
                        </div>
                    </div>

                    <!-- Date Filter -->
                    <div class="col-12 col-md-3">
                        <input type="date" name="filter_date" id="filter_date" class="form-control"
                            value="{{ request('filter_date') }}">
                    </div>

                    <!-- Skop Projek Filter -->
                    <div class="col-12 col-md-3">
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
                            <option value="Lain-lain" {{ request('filter_skop') == 'Lain-lain' ? 'selected' : '' }}>
                                Lain-lain
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
                                <td>
                                    {{ $item->created_at->format('d/m/Y') }}<br>
                                    <span class="text-muted" style="font-size:0.95em">
                                        {{ $item->created_at->format('h:i A') }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        style="max-width: 180px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; vertical-align: middle; cursor: pointer;"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ $item->skop ?? '-' }}">
                                        {{ $item->skop ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        style="max-width: 180px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; vertical-align: middle; cursor: pointer;"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ $item->tajuk ?? '-' }}">
                                        {{ $item->tajuk ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        style="max-width: 180px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; vertical-align: middle; cursor: pointer;"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ $item->jabatan ?? '-' }}">
                                        {{ $item->jabatan ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $status = $item->status_sekretariat ?? 'Dalam Proses';

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

                                        $badgeClass = $statusMap[$status]['class'] ?? 'bg-light text-dark';
                                        $icon = $statusMap[$status]['icon'] ?? 'question-circle-fill';
                                    @endphp

                                    <span
                                        class="badge {{ $badgeClass }} px-3 py-2 fs-6 d-inline-flex align-items-center gap-1 shadow-sm"
                                        style="border-radius: 0.4rem; font-weight: 500; letter-spacing: 0.5px;"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $status }}">
                                        <i class="bi bi-{{ $icon }}" aria-hidden="true"></i>
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
                    {{-- <div class="text-muted">
                        Menunjukkan {{ $permohonan->firstItem() }} - {{ $permohonan->lastItem() }} daripada
                        {{ $permohonan->total() }} rekod
                    </div> --}}
                    <div>
                        {{ $permohonan->onEachSide(1)->links('pagination::bootstrap-5') }}
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

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function(tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>

</body>

</html>
