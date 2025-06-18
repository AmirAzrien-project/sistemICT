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
</head>

<body class="d-flex flex-column h-100">

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
    <div class="container">
        <div class="main-content mt-5">
            <h1 class="text-center mb-4" style="color:#003366;">
                <i class="fas fa-user-plus me-2"></i>Tambah Pengguna Baru
            </h1>

            <form method="post" action="{{ route('pengguna.store') }}" id="userForm" autocomplete="off">
                @csrf
                <div class="form-group mb-4">
                    {{-- <label for="type" class="form-label fw-semibold text-primary">
                        <i class="fas fa-users-cog me-1"></i>
                        Jenis Pengguna <span class="text-danger">*</span>
                    </label> --}}
                    <div class="dropdown">
                        <button
                            class="form-control text-start dropdown-toggle fw-semibold bg-light border-primary shadow-sm"
                            type="button" id="userTypeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <span id="selectedUserType">
                                {{ old('type') == 1 ? 'Pengguna Umum' : (old('type') == 2 ? 'Sekretariat' : (old('type') == 3 ? 'Admin Jabatan' : (old('type') == 4 ? 'Super Admin' : '— Sila Pilih Jenis Pengguna —'))) }}
                            </span>
                        </button>
                        <ul class="dropdown-menu w-100" aria-labelledby="userTypeDropdown" style="min-width:100%">
                            <li><a class="dropdown-item" href="#" data-value="1">Pengguna Umum</a></li>
                            <li><a class="dropdown-item" href="#" data-value="2">Sekretariat</a></li>
                            <li><a class="dropdown-item" href="#" data-value="3">Admin Jabatan</a></li>
                            <li><a class="dropdown-item" href="#" data-value="4">Super Admin</a></li>
                        </ul>
                        <input type="hidden" name="type" id="type" value="{{ old('type') }}">
                    </div>
                    <small class="form-text text-muted ms-1">Sila pilih jenis pengguna sebelum mengisi maklumat lain.
                    </small>
                </div>

                <div class="mb-4">
                    <div class="input-group" style="border-top-right-radius: 0;">
                        <span class="input-group-text">
                            <i class="fa fa-sitemap" aria-hidden="true"></i>
                        </span>
                        <input id="jawatan" name="jawatan" type="text" class="form-control with-icon"
                            placeholder="Jawatan" required>
                    </div>
                    <small class="form-text text-muted">(Contoh: Penolong Pegawai Teknologi Maklumat)</small>
                </div>


                <div class="mb-4">
                    <div class="input-group" style="border-top-right-radius: 0;">
                        <span class="input-group-text">
                            <i class="fa fa-id-card" aria-hidden="true"></i>
                        </span>
                        <select id="jabatanSelect" name="jabatan" class="form-control with-icon" required>
                            <option value="" disabled selected>-- Pilih Jabatan --</option>
                            <optgroup label="Jabatan Negeri:">
                                <option>Pejabat Penasihat Undang-undang Negeri Johor</option>
                                <option>Perbendaharaan Negeri Johor</option>
                                <option>Jabatan Mufti Negeri Johor</option>
                                <option>Jabatan Kehakiman Syariah Negeri Johor</option>
                                <option>Pejabat Tanah Dan Galian Johor</option>
                                <option>Jabatan Agama Islam Negeri Johor</option>
                                <option>Jabatan Pendakwaan Syariah Negeri Johor</option>
                                <option>Suruhanjaya Perkhidmatan Awam Johor</option>
                                <option>Jabatan DiRaja Johor</option>
                                <option>Muzium DiRaja Abu Bakar Istana Besar Johor</option>
                                <option>Pejabat Kebun Bunga Kerajaan Johor</option>
                                <option>Tourism Johor</option>
                                <option>Institut Dato’ Onn</option>
                                <option>Media Digital Johor</option>
                                <option>Unit Strategik Modal Insan Negeri Johor</option>
                            </optgroup>
                            <optgroup label="Pejabat SUK:">
                                <option>Pejabat Jurutulis Dewan Undangan Negeri Johor</option>
                                <option>Pejabat Menteri Besar Johor</option>
                                <option>Pejabat Setiausaha Kerajaan Johor, ICT@Johor</option>
                                <option>Pejabat Setiausaha Kerajaan Johor, Bahagian Kerajaan Tempatan</option>
                                <option>Pejabat Setiausaha Kerajaan Johor, Bahagian Pengurusan Sumber Manusia</option>
                                <option>Pejabat Setiausaha Kerajaan Johor, Bahagian Perancang Ekonomi Negeri Johor
                                </option>
                                <option>Pejabat Setiausaha Kerajaan Johor, Bahagian Pemantauan Projek dan Kesejahteraan
                                    Rakyat</option>
                                <option>Pejabat Setiausaha Kerajaan Johor, Bahagian Khidmat Pengurusan</option>
                                <option>Pejabat Setiausaha Kerajaan Johor, Audit Dalam</option>
                                <option>Badan Kawalselia Air Johor (BAKAJ)</option>
                                <option>Landskap Johor</option>
                                <option>Majlis Sukan Negeri Johor</option>
                            </optgroup>
                            <optgroup label="Pejabat Daerah Negeri Johor:">
                                <option>Pejabat Daerah Johor Bahru</option>
                                <option>Pejabat Daerah Muar</option>
                                <option>Pejabat Daerah Batu Pahat</option>
                                <option>Pejabat Daerah Segamat</option>
                                <option>Pejabat Daerah Kluang</option>
                                <option>Pejabat Daerah Pontian</option>
                                <option>Pejabat Daerah Kota Tinggi</option>
                                <option>Pejabat Daerah Mersing</option>
                                <option>Pejabat Daerah Tangkak</option>
                                <option>Pejabat Daerah Kulai</option>
                            </optgroup>
                            <optgroup label="Pihak Berkuasa Tempatan:">
                                <option>Majlis Bandaraya Johor Bahru</option>
                                <option>Majlis Bandaraya Iskandar Puteri</option>
                                <option>Majlis Bandaraya Pasir Gudang</option>
                                <option>Majlis Perbandaran Batu Pahat</option>
                                <option>Majlis Perbandaran Kluang</option>
                                <option>Majlis Perbandaran Kulai</option>
                                <option>Majlis Perbandaran Muar</option>
                                <option>Majlis Perbandaran Pontian</option>
                                <option>Majlis Perbandaran Segamat</option>
                                <option>Majlis Perbandaran Pengerang</option>
                                <option>Majlis Daerah Kota Tinggi</option>
                                <option>Majlis Daerah Mersing</option>
                                <option>Majlis Daerah Tangkak</option>
                                <option>Majlis Daerah Yong Peng</option>
                                <option>Majlis Daerah Simpang Renggam</option>
                                <option>Majlis Daerah Labis</option>
                            </optgroup>
                            <optgroup label="Jabatan Persekutuan:">
                                <option>Jabatan Kerja Raya Negeri Johor</option>
                                <option>Jabatan Pengairan dan Saliran Negeri Johor</option>
                                <option>Jabatan Pertanian Negeri Johor</option>
                                <option>PLANMalaysia@Johor</option>
                                <option>Jabatan Perhutanan Negeri Johor</option>
                                <option>Jabatan Perkhidmatan Veterinar Negeri Johor</option>
                                <option>Jabatan Kebajikan Masyarakat Negeri Johor</option>
                            </optgroup>
                            <optgroup label="Badan Berkanun:">
                                <option>Majlis Agama Islam Johor</option>
                                <option>Yayasan Pelajaran Johor</option>
                                <option>Perbadanan Islam Johor</option>
                                <option>Perbadanan Kemajuan Perumahan Negeri Johor</option>
                                <option>Perbadanan Stadium Johor</option>
                                <option>Yayasan Warisan Johor</option>
                                <option>Yayasan Pembangunan Keluarga Darul Tak’zim</option>
                                <option>Taman Negara Johor</option>
                                <option>Perbadanan Perpustakaan Awam Johor</option>
                            </optgroup>
                        </select>
                    </div>
                    <small class="form-text text-muted">(Contoh: Jabatan Teknologi Maklumat)</small>
                </div>

                <div class="mb-4">
                    <div class="input-group" style="border-top-right-radius: 0;">
                        <span class="input-group-text">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                        <input id="name" name="name" type="text" class="form-control with-icon"
                            placeholder="Masukkan nama penuh" required autocomplete="off">
                    </div>
                    <small class="form-text text-muted">(Contoh: Ali bin Abu)</small>
                </div>

                <div class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope form" aria-hidden="true"></i>
                        </span>
                        <input id="email" name="email" type="email" class="form-control with-icon"
                            placeholder="Masukkan alamat emel" required autocomplete="off">
                    </div>
                    <small class="form-text text-muted">(Contoh: AliAbu@demo.com)</small>
                </div>

                <div class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-phone"></i>
                        </span>
                        <input id="notel" name="notel" type="text" class="form-control with-icon"
                            placeholder="Masukkan nombor telefon" required maxlength="12" autocomplete="off">
                    </div>
                    <small class="form-text text-muted">(Contoh: 0123456789)</small>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Kata Laluan</label>
                    <div class="input-group position-relative">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input style="max-height: 50px" id="password" name="password" type="password"
                            class="form-control" placeholder="Masukkan kata laluan" required
                            autocomplete="new-password">
                        <button type="button" class="btn btn-outline-secondary toggle-password"
                            onclick="togglePassword('password', this)" aria-label="Toggle password visibility">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="password-instructions mt-2">
                        <small class="text-muted">
                            Gunakan sekurang-kurangnya 8 aksara, termasuk huruf besar, huruf kecil, nombor, dan simbol.
                        </small>
                    </div>
                    <div class="password-strength mt-2">
                        <div class="progress">
                            <div id="passwordStrengthBar" class="progress-bar" role="progressbar"
                                style="width: 0%;"></div>
                        </div>
                        <small id="passwordStrengthText" class="form-text"></small>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Sahkan Kata Laluan</label>
                    <div class="input-group position-relative">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input style="max-height: 50px" id="password_confirmation" name="password_confirmation"
                            type="password" class="form-control" placeholder="Sahkan kata laluan" required
                            autocomplete="new-password">
                        <button type="button" class="btn btn-outline-secondary toggle-password"
                            onclick="togglePassword('password_confirmation', this)"
                            aria-label="Toggle password visibility">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div id="formError" class="alert alert-danger d-none" role="alert"></div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <a href="{{ route('pengguna') }}"
                        class="btn btn-outline-secondary d-inline-flex align-items-center me-md-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-johor">
                        <i class="fas fa-user-plus me-2"></i>Tambah Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer-johor">
        &copy; 2025 Sistem Kerajaan Johor. Hak cipta terpelihara.
    </footer>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Password strength checker
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('passwordStrengthBar');
        const strengthText = document.getElementById('passwordStrengthText');

        passwordInput.addEventListener('input', function() {
            const val = passwordInput.value;
            const strength = calculatePasswordStrength(val);

            // Update progress bar width and color
            strengthBar.style.width = strength.percent + '%';
            strengthBar.className = 'progress-bar ' + strength.colorClass;

            // Update text
            strengthText.textContent = strength.message;
        });

        function calculatePasswordStrength(password) {
            let score = 0;

            if (!password) {
                return {
                    percent: 0,
                    message: '',
                    colorClass: ''
                };
            }

            // Length points
            if (password.length >= 8) score += 1;
            if (password.length >= 12) score += 1;

            // Contains lowercase
            if (/[a-z]/.test(password)) score += 1;

            // Contains uppercase
            if (/[A-Z]/.test(password)) score += 1;

            // Contains number
            if (/\d/.test(password)) score += 1;

            // Contains special char
            if (/[\W_]/.test(password)) score += 1;

            // Map score to percent and message
            const percent = (score / 6) * 100;

            let message = '';
            let colorClass = '';

            if (score <= 2) {
                message = 'Lemah';
                colorClass = 'bg-danger';
            } else if (score <= 4) {
                message = 'Sederhana';
                colorClass = 'bg-warning';
            } else {
                message = 'Kuat';
                colorClass = 'bg-success';
            }

            return {
                percent,
                message,
                colorClass
            };
        }

        document.addEventListener('DOMContentLoaded', function() {
            // HANYA dropdown jenis pengguna
            const userTypeDropdown = document.getElementById('userTypeDropdown');
            const userTypeMenu = userTypeDropdown.nextElementSibling;
            const dropdownItems = userTypeMenu.querySelectorAll('.dropdown-item');
            const selectedUserType = document.getElementById('selectedUserType');
            const typeInput = document.getElementById('type');

            dropdownItems.forEach(function(item) {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    selectedUserType.textContent = this.textContent;
                    typeInput.value = this.getAttribute('data-value');
                });
            });
        });

        document.getElementById('userForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;
            let errorMsg = '';

            if (password.length < 8) {
                errorMsg = 'Kata laluan mesti sekurang-kurangnya 8 aksara.';
            } else if (!/[a-z]/.test(password)) {
                errorMsg = 'Kata laluan mesti mengandungi sekurang-kurangnya satu huruf kecil.';
            } else if (!/[A-Z]/.test(password)) {
                errorMsg = 'Kata laluan mesti mengandungi sekurang-kurangnya satu huruf besar.';
            } else if (!/[0-9]/.test(password)) {
                errorMsg = 'Kata laluan mesti mengandungi sekurang-kurangnya satu nombor.';
            } else if (!/[\W_]/.test(password)) {
                errorMsg = 'Kata laluan mesti mengandungi sekurang-kurangnya satu simbol.';
            } else if (password !== confirm) {
                errorMsg = 'Kata laluan dan pengesahan tidak sepadan.';
            }

            if (errorMsg) {
                e.preventDefault();
                const formError = document.getElementById('formError');
                formError.textContent = errorMsg;
                formError.classList.remove('d-none');
                formError.scrollIntoView({
                    behavior: "smooth"
                });
            }
        });

        document.getElementById('notel').addEventListener('input', function(e) {
            let val = this.value.replace(/\D/g, ''); // Buang semua bukan nombor
            if (val.length > 3) {
                val = val.slice(0, 3) + '-' + val.slice(3, 10);
            }
            this.value = val;
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
