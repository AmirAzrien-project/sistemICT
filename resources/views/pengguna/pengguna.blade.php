<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

    {{-- Notification Alert --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <!-- Main Content -->
    <div class="container my-5">
        <div class="card shadow-sm rounded-4 p-4">
            <h1 class="text-primary mb-4" style="color: #003366; font-weight: 700;">Senarai Pengguna Berdaftar</h1>

            <!-- Search and Filter Section -->
            <div class="row mb-4 align-items-center">
                <div class="col-md-8 d-flex flex-wrap gap-2 align-items-center">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('pengguna') }}" class="input-group flex-grow-1"
                        style="max-width: 400px;">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control border-primary" placeholder="Cari Nama Pengguna"
                            aria-label="Cari Nama Pengguna" style="height: 2.38rem" />
                        <button type="submit" class="btn btn-primary" aria-label="Cari">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>

                    <!-- Filter Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-outline-primary" type="button" id="filterDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false" aria-label="Tapis Pengguna">
                            <i class="fa fa-filter"></i> Tapis
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('pengguna', ['sort' => 'name_asc']) }}">Nama
                                    A-Z</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('pengguna', ['sort' => 'name_desc']) }}">Nama
                                    Z-A</a>
                            </li>
                            <li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <a class="dropdown-item {{ request('type') == '1' ? 'active' : '' }}"
                                    href="{{ route('pengguna', array_merge(request()->except('type'), ['type' => 1])) }}">
                                    Umum
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request('type') == '2' ? 'active' : '' }}"
                                    href="{{ route('pengguna', array_merge(request()->except('type'), ['type' => 2])) }}">
                                    Sekretariat
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request('type') == '3' ? 'active' : '' }}"
                                    href="{{ route('pengguna', array_merge(request()->except('type'), ['type' => 3])) }}">
                                    Admin
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request('type') == '4' ? 'active' : '' }}"
                                    href="{{ route('pengguna', array_merge(request()->except('type'), ['type' => 4])) }}">
                                    Super Admin
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Reset Button -->
                    <a href="{{ route('pengguna') }}" class="btn btn-outline-danger" aria-label="Reset Tapis">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>

                <!-- Tambah Pengguna Button -->
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('pengguna.create') }}" class="btn btn-success fw-semibold">
                        <i class="fas fa-user-plus me-2"></i>Tambah Pengguna
                    </a>
                </div>
            </div>

            <!-- User Table -->
            <div class="table-responsive rounded-3" style="overflow-x:auto; min-width: 0;">
                <table class="table table-striped table-hover align-middle mb-0" style="min-width: 900px;">
                    <thead class="table-primary text-center">
                        <tr style="white-space: nowrap;">
                            <th style="width: 35px;">#</th>
                            <th class="text-start" style="width: 200px;">Nama Penuh</th>
                            <th class="text-start" style="width: 200px;">Emel</th>
                            <th class="text-start" style="width: 200px;">Jawatan</th>
                            <th class="text-start" style="width: 230px;">Jabatan</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                            <tr style="white-space: nowrap;">
                                <td class="text-center">
                                    {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                </td>
                                <td style="text-align: left; max-width: 200px">{{ $user->name }}</td>
                                <td style="text-align: left; max-width: 200px">{{ $user->email }}</td>
                                <td style="text-align: left; max-width: 200px">{{ $user->jawatan ?? '-' }}</td>
                                <td
                                    style="text-align: left; max-width: 230px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; position: relative;">
                                    <span class="jabatan-ellipsis" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ $user->jabatan ?? '-' }}">
                                        {{ $user->jabatan ?? '-' }}
                                    </span>
                                </td>
                                {{-- <td class="text-center">{{ $user->created_at->format('d/m/Y') }}</td> --}}
                                <td style="width: 20px;">
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editUserModal{{ $user->id }}">
                                        <i class="fas fa-edit"></i> Kemaskini
                                    </button>
                                </td>
                            </tr>


                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted fst-italic py-4">Tiada pengguna
                                    ditemui.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Modal UNTUK setiap pengguna -->
            @foreach ($users as $index => $user)
                <!-- Modal -->
                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <!-- FORM UPDATE -->
                        <form method="POST" action="{{ route('pengguna.update', $user->id) }}"
                            class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="modal-content shadow-sm border-0 rounded-3">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Kemaskini Pengguna
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row g-3">
                                        <!-- Jenis Pengguna -->
                                        <div class="col-md-6">
                                            <label for="type-{{ $user->id }}"
                                                class="form-label fw-semibold">Jenis Pengguna</label>
                                            <select id="type-{{ $user->id }}" name="type" class="form-select"
                                                required>
                                                <option value="" disabled>-- Pilih Jenis Pengguna --</option>
                                                <option value="1" {{ $user->type == 1 ? 'selected' : '' }}>
                                                    Pengguna Umum</option>
                                                <option value="2" {{ $user->type == 2 ? 'selected' : '' }}>
                                                    Sekretariat</option>
                                                <option value="3" {{ $user->type == 3 ? 'selected' : '' }}>Admin
                                                    Jabatan</option>
                                                <option value="4" {{ $user->type == 4 ? 'selected' : '' }}>Super
                                                    Admin</option>
                                            </select>
                                            <div class="invalid-feedback">Sila pilih jenis pengguna.</div>
                                        </div>

                                        <!-- Nama -->
                                        <div class="col-md-6">
                                            <label for="name-{{ $user->id }}"
                                                class="form-label fw-semibold">Nama</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i
                                                        class="bi bi-person-fill"></i></span>
                                                <input type="text" id="name-{{ $user->id }}"
                                                    class="form-control" name="name" value="{{ $user->name }}"
                                                    style="height: 3.12rem" required
                                                    placeholder="Masukkan nama penuh">
                                                <div class="invalid-feedback">Sila masukkan nama pengguna.</div>
                                            </div>
                                        </div>

                                        <!-- Email -->
                                        <div class="col-md-6">
                                            <label for="email-{{ $user->id }}"
                                                class="form-label fw-semibold">Email</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i
                                                        class="bi bi-envelope-fill"></i></span>
                                                <input type="email" id="email-{{ $user->id }}"
                                                    class="form-control" name="email" value="{{ $user->email }}"
                                                    style="height: 3.12rem" required placeholder="contoh@domain.com">
                                                <div class="invalid-feedback">Sila masukkan email yang sah.</div>
                                            </div>
                                        </div>

                                        <!-- Jawatan -->
                                        <div class="col-md-6">
                                            <label for="jawatan-{{ $user->id }}"
                                                class="form-label fw-semibold">Jawatan</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                        class="bi bi-briefcase-fill"></i></span>
                                                <input type="text" id="jawatan-{{ $user->id }}"
                                                    class="form-control" name="jawatan" value="{{ $user->jawatan }}"
                                                    style="height: 3.13rem" placeholder="Jawatan pengguna">
                                            </div>
                                        </div>

                                        <!-- Jabatan -->
                                        <div class="col-md-6">
                                            <label for="jabatan-{{ $user->id }}"
                                                class="form-label fw-semibold">Jabatan</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-building"></i></span>
                                                <input type="text" id="jabatan-{{ $user->id }}"
                                                    class="form-control" name="jabatan" value="{{ $user->jabatan }}"
                                                    style="height: 3.13rem" placeholder="Jabatan pengguna">
                                            </div>
                                        </div>

                                        <!-- Tarikh Daftar -->
                                        <div class="col-md-6 position-relative">
                                            <label for="TarikhDaftar-{{ $user->id }}"
                                                class="form-label fw-semibold">Tarikh Daftar</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                        class="bi bi-calendar-event"></i></span>
                                                <input type="date" id="TarikhDaftar-{{ $user->id }}"
                                                    class="form-control" name="TarikhDaftar"
                                                    value="{{ $user->created_at->format('Y-m-d') }}"
                                                    style="height: 3.13rem" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer d-flex justify-content-between">
                                    <!-- Delete Button -->
                                    <button type="button" class="btn btn-outline-danger"
                                        onclick="if(confirm('Padam pengguna ini?')) document.getElementById('delete-user-{{ $user->id }}').submit();">
                                        <i class="bi bi-trash-fill me-1"></i>Padam
                                    </button>

                                    <div>
                                        <!-- Save Button -->
                                        <button type="submit" class="btn btn-primary me-2">
                                            <i class="bi bi-save-fill me-1"></i>Simpan
                                        </button>
                                        <!-- Close Button -->
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Delete Form -->
                        <form id="delete-user-{{ $user->id }}" method="POST"
                            action="{{ route('pengguna.destroy', $user->id) }}" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            @endforeach

            <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
                <div class="text-muted">
                    Menunjukkan {{ $users->firstItem() }} - {{ $users->lastItem() }} daripada {{ $users->total() }}
                    rekod
                </div>
                <div class="d-flex gap-2">
                    {{-- Previous --}}
                    @if ($users->onFirstPage())
                        <span class="btn btn-outline-secondary disabled">
                            <i class="fas fa-chevron-left me-2"></i>Sebelumnya
                        </span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" class="btn btn-outline-primary">
                            <i class="fas fa-chevron-left me-2"></i>Sebelumnya
                        </a>
                    @endif

                    {{-- Next --}}
                    @if ($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" class="btn btn-outline-primary">
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

    <!-- Footer -->
    <footer class="footer-johor mt-auto">
        &copy; 2025 Sistem Kerajaan Johor. Hak cipta terpelihara.
    </footer>

    <!-- Bootstrap & Icons -->
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
        // Bootstrap 5 form validation
        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

</body>

</html>
