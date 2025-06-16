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

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berjaya!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Form Card -->
        <div class="card shadow-sm rounded-4 p-4 mb-5">
            <h2 class="mb-4 text-primary fw-bold" style="color: #003366;">Borang Permohonan</h2>

            <!-- Success message placeholder -->
            <div id="successMessage" class="alert alert-success alert-dismissible fade d-none" role="alert">
                <strong>Berjaya!</strong> Permohonan anda telah dihantar.
                <button type="button" class="btn-close" aria-label="Close" onclick="hideSuccessMessage()"></button>
            </div>

            <!-- Application form -->
            <form id="permohonanForm" method="POST" action="{{ route('permohonan.store') }}"
                enctype="multipart/form-data" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="nama" class="form-label fw-semibold">Nama Pemohon</label>
                    <input type="tel" class="form-control" id="nama" name="nama"
                        value="{{ Auth::user()->name }}" readonly />
                </div>

                <div class="mb-3">
                    <label for="notel" class="form-label fw-semibold">No Telefon</label>
                    <input type="text" class="form-control" id="notel" name="notel" required
                        pattern="[0-9]{10,12}" placeholder="Contoh: 0123456789" value="{{ Auth::user()->notel }}"
                        readonly />
                </div>

                <div class="mb-3">
                    <label for="jabatan" class="form-label fw-semibold">Jabatan</label>
                    <input type="text" class="form-control" id="jabatan" name="jabatan"
                        value="{{ Auth::user()->jabatan }}" readonly />
                </div>

                <div class="mb-3">
                    <label for="skop" class="form-label fw-semibold">Skop Projek <span
                            class="text-danger">*</span></label>
                    <select class="form-select" id="skop" name="skop" required>
                        <option value="" disabled selected>Sila pilih skop projek</option>
                        <option value="Pembangunan Sistem">Pembangunan Sistem</option>
                        <option value="Perkakasan ICT">Perkakasan ICT</option>
                        <option value="Perisian">Perisian</option>
                        <option value="Rangkaian dan Alatan Rangkaian">Rangkaian dan Alatan Rangkaian</option>
                        <option value="Perkhidmatan ICT">Perkhidmatan ICT</option>
                        <option value="Cloud">Cloud</option>
                        <option value="Lain-lain">Lain-lain</option>
                    </select>
                    <div class="invalid-feedback">Sila pilih skop projek.</div>
                </div>

                <div class="mb-3">
                    <label for="tajuk" class="form-label fw-semibold">Nama Projek<span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="tajuk" name="tajuk"
                        placeholder="Masukkan tajuk permohonan" required />
                    <div class="invalid-feedback">Sila isi nama projek.</div>
                </div>

                <div class="mb-4">
                    <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="4"
                        placeholder="Masukkan keterangan (jika ada)"></textarea>
                </div>

                <!-- Dokumen Wajib -->
                <div class="mb-4">
                    <label class="form-label fw-bold fs-5">
                        Senarai Dokumen yang Diperlukan
                    </label>
                    <p class="text-muted mb-3">
                        <span class="fst-italic">*Setiap dokumen adalah wajib untuk permohonan ini.</span><br>
                        <span class="fst-italic"> Format dibenarkan: <b>PDF, Word, Excel</b> sahaja. Maksimum saiz
                            fail: 10MB.</span>
                    </p>

                    <div class="alert d-flex align-items-center mb-4 py-3 px-4 shadow-sm" role="alert"
                        style="background: #fff8e1; border-left: 6px solid #ffc107; border-radius: 0.5rem; font-size:1.08rem; box-shadow: 0 2px 8px rgba(255,193,7,0.08);">
                        <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-3"
                            style="font-size:2.1rem; color:#ff9800;"></i>
                        <div>
                            <strong style="color:#b26a00; font-size:1.1rem;">PERINGATAN:</strong>
                            <span class="ms-1" style="color:#6d4c00;">
                                Sila <b>generate &amp; muat naik <u>Dokumen 4: Kertas Kerja</u></b> dahulu sebelum
                                muat naik dokumen lain.<br>
                                <a href="{{ route('permohonan.tambah') }}"
                                    class="btn btn-warning btn-sm ms-2 mt-2 fw-semibold" style="border-radius:0.4rem;"
                                    target="_blank" rel="noopener noreferrer">
                                    <i class="bi bi-file-earmark-plus"></i> Generate Dokumen 4
                                </a>
                            </span>
                        </div>
                    </div>

                    @php
                        $dokumenList = [
                            1 => 'Senarai Semak Permohonan Kelulusan Teknikal Projek Teknologi Maklumat dan Komunikasi (ICT) Kerajaan Negeri Johor',
                            2 => 'Borang Permohonan Kelulusan Teknikal Projek ICT',
                            3 => 'Cabutan Minit Mesyuarat JPICT Jabatan (berkenaan kelulusan permohonan projek)',
                            4 => 'Kertas Kerja Permohonan Kelulusan Teknikal Projek ICT',
                            5 => 'Slaid Permohonan Kelulusan Teknikal Projek ICT',
                        ];
                    @endphp

                    @foreach ($dokumenList as $key => $dokumen)
                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="dokumen{{ $key }}">
                                Dokumen {{ $key }}: {{ $dokumen }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control" id="dokumen{{ $key }}"
                                name="dokumen{{ $key }}" required accept=".pdf,.doc,.docx,.xls,.xlsx"
                                aria-describedby="dokumen{{ $key }}Help" />
                            <div id="dokumen{{ $key }}Help" class="form-text">
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary px-4 fw-semibold">Hantar Permohonan</button>
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

    <script>
        window.addEventListener('pageshow', function(event) {
            // Hanya clear input yang BUKAN readonly dan BUKAN disabled
            if (event.persisted || performance.getEntriesByType("navigation")[0]?.type === "back_forward") {
                const form = document.getElementById('permohonanForm');
                if (form) {
                    // Senarai ID input yang user kena isi sendiri
                    const manualInputIds = [
                        'skop', 'tajuk', 'keterangan'
                        // tambah ID lain jika ada
                    ];

                    manualInputIds.forEach(function(id) {
                        const el = document.getElementById(id);
                        if (el) {
                            if (el.tagName === 'SELECT') {
                                el.selectedIndex = 0;
                            } else if (el.tagName === 'TEXTAREA') {
                                el.value = '';
                            } else {
                                el.value = '';
                            }
                        }
                    });

                    // Clear semua file input
                    form.querySelectorAll('input[type="file"]').forEach(function(fileInput) {
                        fileInput.value = '';
                    });
                }
            }
        });
    </script>

</body>

</html>
