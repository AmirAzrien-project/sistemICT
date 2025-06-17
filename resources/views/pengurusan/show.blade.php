<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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

<body class="d-flex flex-column min-vh-100">

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

    {{-- Notification --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berjaya!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <main class="container py-4" style="max-width: 1050px; font-family: 'Inter', sans-serif;">
        <!-- Page Title -->
        <h1 class="mb-4 text-primary fw-bold border-bottom pb-2" style="font-size: 2rem; line-height: 1.3;">
            <i class="bi bi-journal-text me-2"></i> Maklumat Permohonan
        </h1>

        <!-- Project Details Card -->
        <section class="bg-white shadow-sm rounded-4 p-4 mb-4" style="box-shadow: 0 3px 15px rgba(0,0,0,0.05);">
            <h2 class="fw-semibold mb-4" style="font-size: 1.5rem; color: #0d6efd;">
                <i class="bi bi-folder2-open me-2"></i> Butiran Projek
            </h2>
            <div class="row gy-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <span class="fw-semibold text-secondary d-block mb-1"><i class="bi bi-card-heading me-1"></i>
                            Nama
                            Projek</span>
                        <div class="fs-6 text-dark border rounded-3 p-2 bg-light">{{ $permohonan->tajuk }}</div>
                    </div>
                    <div class="mb-3">
                        <span class="fw-semibold text-secondary d-block mb-1"><i class="bi bi-diagram-3 me-1"></i>
                            Skop
                            Projek</span>
                        <div class="fs-6 text-dark border rounded-3 p-2 bg-light">
                            {{ $permohonan->skop ?? 'Tiada maklumat' }}</div>
                    </div>
                    <div class="mb-3">
                        <span class="fw-semibold text-secondary d-block mb-1"><i class="bi bi-card-text me-1"></i> No.
                            Rujukan</span>
                        <div class="fs-6 text-dark border rounded-3 p-2 bg-light text-break"
                            style="word-break: break-all; max-width: 100%;">
                            {{ $permohonan->no_rujukan ?? 'Tiada maklumat' }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <span class="fw-semibold text-secondary d-block mb-1"><i class="bi bi-calendar-event me-1"></i>
                            Tarikh Mohon</span>
                        <div class="fs-6 text-dark border rounded-3 p-2 bg-light" style="margin-bottom: 16.5px">
                            {{ \Carbon\Carbon::parse($permohonan->created_at)->translatedFormat('j F Y') }}
                            <span class="text-muted ms-2" style="font-size:0.95em">
                                {{ \Carbon\Carbon::parse($permohonan->created_at)->format('h:i A') }}
                            </span>
                        </div>
                        <div class="mb-3">
                            <span class="fw-semibold text-secondary d-block mb-1"><i class="bi bi-info-circle me-1"></i>
                                Keterangan</span>
                            <div class="fs-6 text-dark border rounded-3 p-2 bg-light fst-italic">
                                {{ $permohonan->keterangan ?? 'Tiada keterangan disediakan.' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <h4 class="fw-semibold mb-3" style="font-size: 1.1rem; color: #0d6efd;">
                        <i class="bi bi-paperclip me-2"></i> Dokumen
                    </h4>
                    @php
                        $dokumenNames = [
                            'Senarai Semak Permohonan Kelulusan Teknikal Projek Teknologi Maklumat dan Komunikasi (ICT) Kerajaan Negeri Johor',
                            'Borang Permohonan Kelulusan Teknikal Projek ICT',
                            'Cabutan Minit Mesyuarat JPICT Jabatan (berkenaan kelulusan permohonan projek)',
                            'Kertas Kerja Permohonan Kelulusan Teknikal Projek ICT',
                            'Slaid Permohonan Kelulusan Teknikal Projek ICT',
                        ];
                        $dokumenIcons = [
                            'bi bi-list-check',
                            'bi bi-file-earmark-text',
                            'bi bi-journal-text',
                            'bi bi-file-earmark-richtext',
                            'bi bi-file-earmark-slides',
                        ];
                        $dokumens = [
                            $permohonan->dokumen1,
                            $permohonan->dokumen2,
                            $permohonan->dokumen3,
                            $permohonan->dokumen4,
                            $permohonan->dokumen5,
                        ];
                    @endphp
                    <div class="row row-cols-1 row-cols-md-2 g-3">
                        @forelse ($dokumens as $index => $file)
                            @if ($file)
                                <div class="col">
                                    <div class="border rounded-3 p-3 d-flex align-items-center gap-3 h-100 bg-light">
                                        <i class="{{ $dokumenIcons[$index] }} text-primary fs-3"></i>
                                        <a href="{{ asset('storage/dokumen/' . $file) }}" target="_blank"
                                            class="text-decoration-none text-dark fw-semibold flex-grow-1">
                                            {{ $dokumenNames[$index] }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="col">
                                <div class="alert alert-info mb-0">Tiada dokumen dimuat naik.</div>
                            </div>
                        @endforelse
                    </div>
                </div>
        </section>

        <!-- User Info and Status Section -->
        <section class="row g-3">
            <!-- User Info -->
            <div class="col-md-6">
                <div class="bg-white shadow-sm rounded-4 p-4 h-100" style="box-shadow: 0 3px 15px rgba(0,0,0,0.05);">
                    <h3 class="fw-semibold mb-4" style="color: #0dcaf0; font-size: 1.2rem;">
                        <i class="bi bi-person-circle me-2"></i> Maklumat Pemohon
                    </h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 border-0">
                            <strong><i class="bi bi-person me-1 text-info"></i> Nama:</strong>
                            <span class="ms-1">{{ $permohonan->name }}</span>
                        </li>
                        <li class="list-group-item px-0 border-0">
                            <strong><i class="bi bi-card-heading me-1 text-info"></i> ID:</strong>
                            <span class="ms-1">{{ $permohonan->id_pekerja }}</span>
                        </li>
                        <li class="list-group-item px-0 border-0">
                            <strong><i class="bi bi-telephone-fill me-1 text-info"></i> No Telefon:</strong>
                            <span class="ms-1">{{ $permohonan->notel }}</span>
                        </li>
                        <li class="list-group-item px-0 border-0">
                            <strong><i class="bi bi-building me-1 text-info"></i> Jabatan:</strong>
                            <span class="ms-1">{{ $permohonan->jabatan }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Status Semasa -->
            <div class="col-md-6">
                <div class="bg-white shadow-sm rounded-4 p-4 h-100" style="box-shadow: 0 3px 15px rgba(0,0,0,0.05);">
                    <h3 class="fw-semibold mb-4" style="color: #198754; font-size: 1.2rem;">
                        <i class="bi bi-clipboard-check me-2"></i> Status Semasa
                    </h3>
                    <div class="mb-3 d-flex align-items-center">
                        <span class="fw-semibold" style="font-size: 1rem;">
                            <i class="bi bi-info-circle me-1 text-success"></i> Status Terkini:
                        </span>
                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-semibold fs-6 ms-2"
                            style="letter-spacing: 0.02em;">
                            {{ $permohonan->status_sekretariat }}
                        </span>
                    </div>
                    <form action="{{ url('/pengurusan/permohonan/' . $permohonan->id . '/status') }}" method="POST"
                        id="statusUpdateForm">
                        @csrf
                        <label for="statusSekretariat" class="form-label fw-semibold mb-2" style="font-size: 1rem;">
                            <i class="bi bi-pencil-square me-1 text-success"></i> Kemaskini Status
                        </label>
                        <select id="statusSekretariat" name="status_sekretariat" class="form-select mb-3 fs-6"
                            required>
                            <option value="Menunggu"
                                {{ $permohonan->status_sekretariat == 'Menunggu' ? 'selected' : '' }} hidden>
                                Menunggu
                            </option>
                            <option value="Tidak Lengkap"
                                {{ $permohonan->status_sekretariat == 'Tidak Lengkap' ? 'selected' : '' }}>
                                Tidak Lengkap
                            </option>
                            <option value="Perlu Semakan Semula"
                                {{ $permohonan->status_sekretariat == 'Perlu Semakan Semula' ? 'selected' : '' }}>
                                Perlu Semakan Semula
                            </option>
                            <option value="Disyorkan"
                                {{ $permohonan->status_sekretariat == 'Disyorkan' ? 'selected' : '' }}>
                                Disyorkan
                            </option>
                        </select>
                        <button type="submit" class="btn btn-success w-100 fw-semibold fs-6">
                            <i class="bi bi-arrow-repeat me-2"></i> Kemaskini Status
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Back Button -->
        <div class="mt-4 text-end">
            <a href="{{ route('pengurusan.index') }}" class="btn btn-outline-secondary btn-lg fw-semibold px-4 fs-6">
                <i class="bi bi-arrow-left-circle me-2"></i> Kembali ke Senarai
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer-johor mt-auto">
        &copy; 2025 Sistem Kerajaan Johor. Hak cipta terpelihara.
    </footer>

    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
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
