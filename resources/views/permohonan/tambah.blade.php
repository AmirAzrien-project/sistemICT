<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sistem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Roboto:wght@400;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    @vite(['resources/css/home.css'])
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
                        <a class="nav-link nav-link-johor" href="{{ route('permohonan.index') }}">PERMOHONAN</a>
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

    <main class="container my-5">
        <h2 class="mb-4 text-center">Borang Permohonan ICT</h2>

        <form method="POST" action="{{ route('permohonan.generatePdf') }}" oninput="kiraJumlah()" target="_blank">
            @csrf

            <div class="mb-3">
                <label for="tajuk" class="form-label">Tajuk Permohonan:</label>
                <input type="text" class="form-control" id="tajuk" name="tajuk" required />
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" required />
            </div>

            <!-- Seksyen 2.0 Latar Belakang -->
            <div class="mb-4">
                <label class="form-label">2.0 Latar Belakang:</label>
                <textarea class="form-control mb-2 word-textbox" name="tajuk_latar_belakang" rows="3"
                    placeholder="Contoh: Sistem sedia ada memerlukan penambahbaikan untuk menyokong operasi jabatan secara digital."
                    required></textarea>

                <div id="latar_belakang_list">
                    <ol type="i">
                        <li>
                            <div class="d-flex mb-2">
                                <input type="text" class="form-control me-2" name="latar_belakang[]"
                                    placeholder="Contoh: Sistem lama tidak menyokong integrasi dengan aplikasi baru."
                                    required>
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="buangIsi(this)">Buang</button>
                            </div>
                        </li>
                    </ol>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary"
                    onclick="tambahIsi('latar_belakang_list', 'latar_belakang[]')">Tambah Isi</button>
            </div>

            <!-- Seksyen 3.0 Kekangan -->
            <div class="mb-4">
                <label class="form-label">3.0 Kekangan Sistem Sedia Ada:</label>
                <textarea class="form-control mb-2 word-textbox" name="tajuk_kekangan" rows="3"
                    placeholder="Contoh: Kekangan utama adalah dari segi kapasiti storan dan keselamatan data yang tidak mencukupi."
                    required></textarea>
            </div>

            <!-- Seksyen 4.0 Objektif -->
            <div class="mb-4">
                <label class="form-label">4.0 Objektif:</label>
                <textarea class="form-control mb-2 word-textbox" name="tajuk_objektif" rows="3"
                    placeholder="Contoh: Meningkatkan kecekapan pengurusan data dan mempercepatkan proses kerja jabatan." required></textarea>

                <div id="objektif_list">
                    <ol type="i">
                        <li>
                            <div class="d-flex mb-2">
                                <input type="text" class="form-control me-2" name="objektif[]"
                                    placeholder="Contoh: Memastikan data dapat diakses secara atas talian." required>
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="buangIsi(this)">Buang</button>
                            </div>
                        </li>
                    </ol>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary"
                    onclick="tambahIsi('objektif_list', 'objektif[]')">Tambah Isi</button>
            </div>

            <!-- Seksyen 5.0 Justifikasi Pembangunan CR -->
            <div class="mb-4">
                <label class="form-label">5.0 Justifikasi Pembangunan CR:</label>
                <textarea class="form-control mb-2 word-textbox" name="tajuk_justifikasi" rows="3"
                    placeholder="Contoh: Pembangunan CR diperlukan untuk memenuhi keperluan operasi semasa dan meningkatkan keselamatan sistem."
                    required></textarea>

                <div id="justifikasi_list">
                    <ol type="i">
                        <li>
                            <div class="d-flex mb-2">
                                <input type="text" class="form-control me-2" name="justifikasi[]"
                                    placeholder="Contoh: CR akan membolehkan automasi proses yang sebelum ini dilakukan secara manual."
                                    required>
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="buangIsi(this)">Buang</button>
                            </div>
                        </li>
                    </ol>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary"
                    onclick="tambahIsi('justifikasi_list', 'justifikasi[]')">Tambah Isi</button>
            </div>

            <!-- Seksyen 6.0 Implikasi Kewangan -->
            <h5 class="mt-5 mb-3">6.0 Implikasi Kewangan:</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="implikasiTable">
                    <thead class="table-light text-center">
                        <tr>
                            <th>BIL</th>
                            <th>KETERANGAN</th>
                            <th>JUMLAH (RM)</th>
                            <th>SST (RM) 8%</th>
                            <th>JUMLAH (RM) + SST</th>
                            <th>TINDAKAN</th>
                        </tr>
                    </thead>
                    <tbody id="implikasiBody">
                        <tr>
                            <td class="text-center">1</td>
                            <td><input type="text" name="keterangan[]" class="form-control" required></td>
                            <td><input type="number" name="jumlah[]" class="form-control" step="0.01"
                                    min="0" value="0" required></td>
                            <td class="sst text-end">0.00</td>
                            <td class="total text-end">0.00</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="buangBaris(this)">Buang</button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="2" class="text-end">JUMLAH KESELURUHAN</td>
                            <td id="total_keseluruhan" class="text-end">0.00</td>
                            <td id="sst_keseluruhan" class="text-end">0.00</td>
                            <td id="jumlah_akhir" class="text-end">0.00</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="text-end mb-3">
                <button type="button" class="btn btn-primary" onclick="tambahBaris()">+ Tambah Baris</button>
            </div>
            <input type="hidden" id="jumlah_akhir_input" name="jumlah_akhir" value="0.00">

            <div class="row mt-4">
                <div class="col-md-6 mb-3">
                    <label for="nama_penyelaras" class="form-label">Nama Pegawai Penyelaras:</label>
                    <input type="text" class="form-control" id="nama_penyelaras" name="nama_penyelaras"
                        required />
                </div>

                <div class="col-md-6 mb-3">
                    <label for="jawatan" class="form-label">Jawatan:</label>
                    <input type="text" class="form-control" id="jawatan" name="jawatan" required />
                </div>

                <div class="col-md-6 mb-3">
                    <label for="gred_jawatan" class="form-label">Gred Jawatan:</label>
                    <input type="text" class="form-control" id="gred_jawatan" name="gred_jawatan" required />
                </div>

                <div class="col-md-6 mb-3">
                    <label for="notel" class="form-label">No Telefon:</label>
                    <input type="tel" class="form-control" id="notel" name="notel" required />
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nofax" class="form-label">No Fax:</label>
                    <input type="tel" class="form-control" id="nofax" name="nofax" />
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">E-mel:</label>
                    <input type="email" class="form-control" id="email" name="email" required />
                </div>

            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success px-4 py-2">Hantar &amp; Generate PDF</button>
            </div>
        </form>
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
        // Hide loading overlay (optional)
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
    <script>
        function kiraJumlah() {
            const rows = document.querySelectorAll("#implikasiBody tr");
            let totalJumlah = 0,
                totalSST = 0,
                totalAkhir = 0;
            rows.forEach(row => {
                const jumlahInput = row.querySelector('input[name="jumlah[]"]');
                const sstCell = row.querySelector(".sst");
                const totalCell = row.querySelector(".total");
                let jumlah = parseFloat(jumlahInput?.value) || 0;
                let sst = jumlah * 0.08;
                let jumlahTermasukSST = jumlah + sst;
                if (sstCell) sstCell.textContent = sst.toFixed(2);
                if (totalCell) totalCell.textContent = jumlahTermasukSST.toFixed(2);
                totalJumlah += jumlah;
                totalSST += sst;
                totalAkhir += jumlahTermasukSST;
            });
            document.getElementById("total_keseluruhan").textContent = totalJumlah.toFixed(2);
            document.getElementById("sst_keseluruhan").textContent = totalSST.toFixed(2);
            document.getElementById("jumlah_akhir").textContent = totalAkhir.toFixed(2);
            document.getElementById("jumlah_akhir_input").value = totalAkhir.toFixed(2);
        }
        document.addEventListener('input', function(e) {
            if (e.target && e.target.matches('input[name="jumlah[]"]')) {
                kiraJumlah();
            }
        });

        function tambahBaris() {
            const tbody = document.getElementById('implikasiBody');
            const rowCount = tbody.rows.length + 1;
            const tr = document.createElement('tr');
            tr.innerHTML = `
    <td class="text-center">${rowCount}</td>
    <td><input type="text" name="keterangan[]" class="form-control" required></td>
    <td><input type="number" name="jumlah[]" class="form-control" step="0.01" min="0" value="0" required></td>
    <td class="sst text-end">0.00</td>
    <td class="total text-end">0.00</td>
    <td class="text-center">
        <button type="button" class="btn btn-danger btn-sm" onclick="buangBaris(this)">Buang</button>
    </td>
    `;
            tbody.appendChild(tr);
            kiraJumlah();
        }

        function buangBaris(button) {
            const tr = button.closest('tr');
            tr.remove();
            const rows = document.querySelectorAll('#implikasiBody tr');
            rows.forEach((row, idx) => {
                row.cells[0].textContent = idx + 1;
            });
            kiraJumlah();
        }
        window.addEventListener('DOMContentLoaded', kiraJumlah);

        function tambahIsi(listId, inputName) {
            const list = document.getElementById(listId).querySelector('ol');
            const li = document.createElement('li');
            li.innerHTML = `
        <div class="d-flex mb-2">
            <input type="text" class="form-control me-2" name="${inputName}" required>
            <button type="button" class="btn btn-danger btn-sm" onclick="buangIsi(this)">Buang</button>
        </div>
    `;
            list.appendChild(li);
        }

        function buangIsi(button) {
            const li = button.closest('li');
            if (li) li.remove();
        }
    </script>

</body>

</html>
