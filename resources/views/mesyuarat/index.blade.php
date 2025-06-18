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
    @include('layouts.navigation')
    <div class="container">
        @yield('content')
    </div>

    <!-- Main content -->
    <main class="container my-5">
        <div class="container">
            <h3 class="mb-4 fw-bold text-primary">Senarai Permohonan Disyorkan</h3>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="alert alert-info d-flex align-items-center gap-2 mb-4" role="alert" style="font-size: 1rem;">
                <i class="bi bi-info-circle-fill fs-4 text-primary"></i>
                <div>
                    <ul class="mb-0 ps-3">
                        <li>Setiap permohonan <b>wajib melalui Mesyuarat Pertama sebelum Mesyuarat Kedua</b>. Sila
                            pastikan urutan mesyuarat dipatuhi.</li>
                        <li>Maklumat yang disimpan hendaklah <b>tepat dan lengkap</b> bagi mengelakkan sebarang masalah
                            semakan atau kelulusan.</li>
                        <li>Hanya permohonan yang telah lengkap kedua-dua mesyuarat dan mempunyai <b>No Sijil</b> akan
                            dipaparkan status <span class="badge bg-success rounded-1">Selesai</span>.</li>
                    </ul>
                </div>
            </div>

            <form method="GET" class="row g-2 align-items-end mb-3">
                <div class="col-md-4">
                    <input type="text" name="search_nama" value="{{ request('search_nama') }}" class="form-control"
                        placeholder="Nama Mesyuarat">
                </div>
                <div class="col-md-4">
                    <input type="text" name="search_jabatan" value="{{ request('search_jabatan') }}"
                        class="form-control" placeholder="Jabatan">
                </div>
                <div class="col-md-3">
                    <select name="sort_status" class="form-select" style="width:42%">
                        <option value="">-- Pilih --</option>
                        <option value="lulus" {{ request('sort_status') == 'lulus' ? 'selected' : '' }}>Selesai
                            (Lulus)</option>
                        <option value="belum" {{ request('sort_status') == 'belum' ? 'selected' : '' }}>Belum
                            Selesai</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex gap-1">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i></button>
                    <a href="{{ route('mesyuarat.index') }}" class="btn btn-outline-secondary w-100" title="Reset">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
                {{-- <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i></button>
                </div> --}}
            </form>

            <div class="table-responsive rounded shadow-sm">
                <table class="table table-bordered align-middle table-hover">
                    <thead class="table-primary">
                        <tr>
                            {{-- <th style="width: 15%;">No Rujukan</th> --}}
                            <th style="width: 15%;">Tarikh</th>
                            <th style="width: 20%;">Nama Projek</th>
                            <th style="width: 20%;">Jabatan</th>
                            <th style="width: 20%;">Mesyuarat JPICT Jabatan</th>
                            <th style="width: 20%;">Mesyuarat JPICT Negeri</th>
                            <th style="width: 10%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($permohonans as $p)
                            <tr>
                                {{-- <td style="text-align:left">{{ $p->no_rujukan }}</td> --}}
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($p->created_at)->format('d/m/Y') }}<br>
                                    <span class="text-muted" style="font-size:0.95em">
                                        {{ \Carbon\Carbon::parse($p->created_at)->format('h:i A') }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <span
                                        style="max-width: 180px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; vertical-align: middle; cursor: pointer;"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $p->tajuk }}">
                                        {{ $p->tajuk }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <span
                                        style="max-width: 180px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; vertical-align: middle; cursor: pointer;"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $p->jabatan }}">
                                        {{ $p->jabatan }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('mesyuarat.edit', ['permohonan_id' => $p->id, 'peringkat_mesyuarat' => 1]) }}"
                                        class="btn btn-outline-primary rounded px-4 py-2 d-inline-flex align-items-center gap-2 shadow-sm"
                                        style="font-weight: 500;">
                                        Kemaskini
                                    </a>
                                </td>
                                <td class="align-middle text-center">
                                    @if ($p->mesy1_selesai)
                                        <a href="{{ route('mesyuarat.edit', ['permohonan_id' => $p->id, 'peringkat_mesyuarat' => 2]) }}"
                                            class="btn btn-outline-success rounded-1 px-4 py-2 d-inline-flex align-items-center gap-2 shadow-sm"
                                            style="font-weight: 500;">
                                            Kemaskini
                                        </a>
                                    @else
                                        <button type="button"
                                            class="btn btn-outline-secondary rounded-1 px-4 py-2 d-inline-flex align-items-center gap-2 shadow-sm"
                                            disabled>
                                            Kemaskini
                                        </button>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    @if ($p->status_lulus == 'Lulus')
                                        <span class="badge bg-success rounded-1 px-3 py-2">Selesai</span>
                                    @else
                                        <span class="badge bg-secondary rounded-1 px-3 py-2">Belum Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-info-circle me-2"></i>Tiada permohonan disyorkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-4">
                    {{ $permohonans->withQueryString()->links('pagination::bootstrap-5') }}
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

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function(tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>

</body>

</html>
