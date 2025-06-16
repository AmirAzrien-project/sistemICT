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
            <div
                class="card shadow-sm border-0 mb-4
                @if ($peringkat_mesyuarat == 2) border-success @else border-primary @endif">
                <div
                    class="card-header
                    @if ($peringkat_mesyuarat == 2) bg-success text-white @else bg-primary text-white @endif">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi {{ $peringkat_mesyuarat == 2 ? 'bi-building' : 'bi-people' }} fs-4"></i>
                        <span class="fw-semibold">
                            @if ($peringkat_mesyuarat == 1)
                                Mesyuarat JPICT Jabatan
                            @elseif ($peringkat_mesyuarat == 2)
                                Mesyuarat JPICT Negeri
                            @else
                                Mesyuarat
                            @endif
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-3">{{ $permohonan->tajuk }}</h5>
                    <div class="mb-2">
                        <span class="text-muted">No Rujukan:</span>
                        <span class="fw-semibold">{{ $permohonan->no_rujukan }}</span>
                    </div>
                    @if ($peringkat_mesyuarat == 2)
                        <div class="mb-2">
                            <span class="text-muted">No Sijil:</span>
                            <span class="fw-semibold">{{ $mesyuarat?->no_sijil ?? '-' }}</span>
                        </div>
                    @endif

                    <form action="{{ route('mesyuarat.store') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="no_rujukan" value="{{ $permohonan->no_rujukan }}">
                        <input type="hidden" name="permohonan_id" value="{{ $permohonan->id }}">
                        <input type="hidden" name="peringkat_mesyuarat" value="{{ $peringkat_mesyuarat }}">

                        <div class="mb-3">
                            <label for="tajuk" class="form-label">Nama Projek</label>
                            <input type="text" name="tajuk" class="form-control"
                                value="{{ $permohonan->tajuk ?? '' }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="nilai_projek" class="form-label">Nilai Projek (RM)</label>
                            <input type="text" name="nilai_projek" class="form-control"
                                value="{{ $mesyuarat->nilai_projek ?? ($nilai_projek_mesy1 ?? ($permohonan->nilai_projek ?? '')) }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="keputusan" class="form-label">Keputusan</label>
                            <select name="keputusan" id="keputusan" class="form-select" required>
                                @php
                                    $keputusanOptions = ['Disyorkan', 'Tidak Disyorkan', 'Semakan Semula'];
                                    if ($peringkat_mesyuarat == 2) {
                                        $keputusanOptions[] = 'Lulus';
                                    }
                                    $selectedKeputusan = $mesyuarat->keputusan ?? '';
                                @endphp
                                <option value="" hidden disabled
                                    {{ $selectedKeputusan == '' ? 'selected' : '' }}>-- Pilih
                                    Keputusan --</option>
                                @foreach ($keputusanOptions as $option)
                                    <option value="{{ $option }}"
                                        {{ $selectedKeputusan == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @if ($peringkat_mesyuarat == 2)
                            <div class="mb-3" style="display: none;">
                                <label for="no_sijil" class="form-label">No Sijil</label>
                                <input type="text" id="no_sijil" class="form-control"
                                    value="{{ $mesyuarat->no_sijil ?? ($selectedKeputusan == 'Lulus' ? 'Akan dijana selepas simpan' : '') }}"
                                    readonly>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="tarikh_masa" class="form-label">Tarikh & Masa</label>
                            <input type="datetime-local" name="tarikh_masa" class="form-control"
                                value="{{ $mesyuarat?->tarikh_masa ? date('Y-m-d\TH:i', strtotime($mesyuarat->tarikh_masa)) : '' }}"
                                required>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit"
                                class="btn @if ($peringkat_mesyuarat == 2) btn-success @else btn-primary @endif px-4 fw-semibold">
                                <i class="bi bi-save me-2"></i> Simpan
                            </button>
                            <a href="{{ route('mesyuarat.index') }}"
                                class="btn btn-outline-secondary px-4 fw-semibold">
                                <i class="bi bi-arrow-left me-2"></i> Kembali
                            </a>
                            @if ($peringkat_mesyuarat == 1 && isset($mesyuarat) && $mesyuarat->keputusan === 'Disyorkan')
                                <a style="color: #ffffff"
                                    href="{{ route('mesyuarat.edit', ['permohonan_id' => $permohonan->id, 'peringkat_mesyuarat' => 2]) }}"
                                    class="btn btn-info px-4 fw-semibold ms-auto">
                                    <i class="bi bi-arrow-right-circle me-2"></i>
                                    Teruskan ke Mesyuarat JPICT Negeri
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            const keputusanSelect = document.getElementById('keputusan');
            const noSijilInput = document.getElementById('no_sijil');

            function toggleNoSijil() {
                if (keputusanSelect.value === 'Lulus') {
                    noSijilInput.disabled = false;
                    noSijilInput.required = true;
                } else {
                    noSijilInput.disabled = true;
                    noSijilInput.required = false;
                    noSijilInput.value = '';
                }
            }

            if (keputusanSelect && noSijilInput) {
                toggleNoSijil(); // Initial check
                keputusanSelect.addEventListener('change', toggleNoSijil);
            }
        });
    </script>

    @if (session('updated'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Makluman',
                    text: '{{ session('updated') }}',
                    confirmButtonText: 'OK'
                }).then(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berjaya!',
                        text: '{{ session('success') }}',
                        confirmButtonText: 'OK'
                    });
                });
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berjaya!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Makluman',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

</body>

</html>
