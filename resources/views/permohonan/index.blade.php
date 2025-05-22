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
                    <li class="nav-item">
                        <a class="nav-link nav-link-johor active" href="{{ route('permohonan.index') }}">PERMOHONAN</a>
                    </li>
                    @if (in_array(auth()->user()->type, [2, 3, 4]))
                        <li class="nav-item">
                            <a class="nav-link nav-link-johor" href="{{ route('pengurusan.index') }}">PENGURUSAN</a>
                        </li>
                    @endif
                    @if (in_array(auth()->user()->type, [2, 3, 4]))
                        <li class="nav-item">
                            <a class="nav-link nav-link-johor" href="{{ route('mesyuarat.index') }}">MESYUARAT</a>
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

                    @php
                        $dokumenList = [
                            1 => 'Senarai Semak Permohonan Kelulusan Teknikal Projek Teknologi Maklumat dan Komunikasi (ICT) Kerajaan Negeri Johor',
                            2 => 'Borang Permohonan Kelulusan Teknikal Projek ICT',
                            3 => 'Cabutan Minit Mesyuarat JPICT Jabatan (berkenaan kelulusan permohonan projek)',
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
            <br>
            <a href="{{ route('permohonan.tambah') }}" class="btn btn-primary px-4 fw-semibold">
                Isi Dokumen 4 : Kertas Kerja
            </a>
        </div>

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
                                        ];

                                        // Fallback if status not in map
                                        $badgeClass = $statusMap[$status]['class'] ?? 'bg-light text-dark';
                                        $icon = $statusMap[$status]['icon'] ?? 'question-circle-fill';
                                    @endphp

                                    <span
                                        class="badge rounded-pill {{ $badgeClass }} px-3 py-2 fs-6 d-inline-flex align-items-center gap-1 shadow-sm"
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

</body>

</html>
