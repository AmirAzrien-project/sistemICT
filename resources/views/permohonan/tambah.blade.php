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
    <style>
        .table-fixed {
            table-layout: fixed;
            width: 100%;
        }
    </style>
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
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-johor dropdown-toggle active" href="{{ route('permohonan.index') }}"
                            id="permohonanDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            PERMOHONAN
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="permohonanDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('permohonan.index') }}">PERMOHONAN</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('permohonan.senarai') }}">SENARAI</a>
                            </li>
                            @if (in_array(auth()->user()->type, [2, 3, 4]))
                                <li>
                                    <a class="dropdown-item" href="{{ route('pengurusan.index') }}">PENGURUSAN</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    @if (in_array(auth()->user()->type, [2, 3, 4]))
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-link-johor dropdown-toggle" href="{{ route('mesyuarat.index') }}"
                                id="mesyuaratDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                MESYUARAT
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="mesyuaratDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('mesyuarat.index') }}">MESYUARAT</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('mesyuarat.index') }}">PENGURUSAN</a>
                                </li>
                            </ul>
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

    <main class="container my-5" style="max-width: 70%;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0 text-center flex-grow-1">Kertas Kerja Permohonan Kelulusan Teknikal Projek ICT</h2>
        </div>

        <form method="POST" action="{{ route('permohonan.generatePdf') }}" oninput="kiraJumlah()"
            enctype="multipart/form-data" target="_blank" autocomplete="off" id="formGenerate">
            @csrf

            <div class="mb-3">
                <label for="tajuk" class="form-label">Tajuk Permohonan:</label>
                <input type="text" class="form-control" id="tajuk" name="tajuk" required />
            </div>

            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan:</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan"
                    value="{{ auth()->user()->jabatan ?? '' }}" required />
            </div>
            <br>
            <br>

            <!-- Seksyen 2.0 Latar Belakang -->
            <div class="mb-4">
                <label class="form-label">2.0 Latar Belakang:</label>
                <textarea class="form-control mb-2 word-textbox" name="tajuk_latar_belakang" rows="3"
                    placeholder="Contoh: Sistem sedia ada memerlukan penambahbaikan untuk menyokong operasi jabatan secara digital."
                    required>
                </textarea>
                <br>
            </div>
            <br><br>

            <!-- Seksyen 3.0 Kekangan -->
            <div class="mb-4">
                <label class="form-label">3.0 Kekangan Sistem Sedia Ada:</label>
                <textarea class="form-control mb-2 word-textbox" name="tajuk_kekangan" rows="3"
                    placeholder="Contoh: Kekangan utama adalah dari segi kapasiti storan dan keselamatan data yang tidak mencukupi."
                    required>
                </textarea>
            </div>
            <br><br>

            <!-- Seksyen 4.0 Objektif -->
            <div class="mb-4">
                <label class="form-label">4.0 Objektif:</label>
                <textarea class="form-control mb-2 word-textbox" name="tajuk_objektif" rows="3"
                    placeholder="Contoh: Meningkatkan kecekapan pengurusan data dan mempercepatkan proses kerja jabatan." required>
                </textarea><br>
            </div>
            <br><br>

            <!-- Seksyen 5.0 Justifikasi Pembangunan CR -->
            <div class="mb-4">
                <label class="form-label">5.0 Justifikasi Pembangunan CR:</label>
                <textarea class="form-control mb-2 word-textbox" name="tajuk_justifikasi" rows="3"
                    placeholder="Contoh: Pembangunan CR diperlukan untuk memenuhi keperluan operasi semasa dan meningkatkan keselamatan sistem."
                    required>
                </textarea><br>
            </div><br>

            <!-- Seksyen 6.0 Implikasi Kewangan -->
            <h5 class="mt-5 mb-3">6.0 Implikasi Kewangan:</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle table-fixed" id="implikasiTable">
                    <thead class="table-light text-center">
                        <tr>
                            <th style="width: 5%">BIL</th>
                            <th style="width: 18%">KETERANGAN</th>
                            <th style="width: 15%">KOS UNIT (RM)</th>
                            <th style="width: 18%">SST (RM)</th>
                            <th style="width: 14%">KOS UNIT + SST</th>
                            <th style="width: 12%">TINDAKAN</th>
                        </tr>
                    </thead>
                    <tbody id="implikasiBody">
                        <tr>
                            <td class="text-center">1</td>
                            <td><input type="text" name="keterangan[]" class="form-control text-center" required>
                            </td>
                            <td><input type="number" name="jumlah[]" class="form-control text-center"
                                    step="0.01" min="0" value="0" required></td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <select name="sst_flag[]" class="form-select sst-flag text-center"
                                        style="width:auto" required>
                                        <option value="Tiada">Tiada</option>
                                        <option value="Ada">Ada</option>
                                    </select>
                                    <span class="sst">0.00</span>
                                </div>
                            </td>
                            <td class="total text-center">0.00</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="buangBaris(this)">Buang</button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="2" class="text-end">KOS KESELURUHAN</td>
                            <td id="total_keseluruhan" class="text-end">0.00</td>
                            <td id="sst_keseluruhan" class="text-end">0.00</td>
                            <td id="jumlah_akhir" class="text-end">0.00</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="text-end mb-3">
                <button type="button" class="btn btn-primary" onclick="tambahBaris()">+ Tambah</button>
            </div>
            <input type="hidden" id="jumlah_akhir_input" name="jumlah_akhir" value="0.00">
            <br>
            <br>

            <div class="row mt-4">
                <div class="col-md-6 mb-3">
                    <label for="nama_penyelaras" class="form-label">Nama Pegawai Penyelaras:</label>
                    <input type="text" class="form-control" id="nama_penyelaras" name="nama_penyelaras"
                        value="{{ auth()->user()->name ?? '' }}" required />
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">E-mel:</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="{{ auth()->user()->email ?? '' }}" required />
                </div>

                <div class="col-md-6 mb-3">
                    <label for="jawatan" class="form-label">Jawatan:</label>
                    <input type="text" class="form-control" id="jawatan" name="jawatan"
                        value="{{ auth()->user()->jawatan ?? '' }}" required />
                </div>

                <div class="col-md-6 mb-3">
                    <label for="notel" class="form-label">No Telefon:</label>
                    <input type="tel" class="form-control" id="notel" name="notel" required />
                </div>

                <div class="col-md-6 mb-3">
                    <label for="gred_jawatan" class="form-label">Gred Jawatan:</label>
                    <input type="text" class="form-control" id="gred_jawatan" name="gred_jawatan" required />
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nofax" class="form-label">No Fax:</label>
                    <input type="tel" class="form-control" id="nofax" name="nofax" />
                </div>

            </div>

            <div class="row justify-content-center mt-5">
                <div class="col-12 col-md-8">
                    <div class="d-flex flex-column flex-md-row justify-content-center align-items-stretch gap-5">
                        <button type="submit"
                            class="btn btn-success btn-lg px-4 py-2 d-flex align-items-center justify-content-center gap-2 flex-fill shadow-sm">
                            <i class="bi bi-file-earmark-plus"></i>
                            Jana Dokumen
                        </button>
                        <button type="button"
                            class="btn btn-secondary btn-lg px-4 py-2 d-flex align-items-center justify-content-center gap-2 flex-fill shadow-sm"
                            onclick="location.replace(location.pathname);">
                            <i class="bi bi-arrow-clockwise"></i>
                            Reset Borang
                        </button>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <a href="{{ route('permohonan.index') }}"
                            class="btn btn-warning btn-lg px-4 py-2 d-flex align-items-center justify-content-center gap-2 shadow-sm"
                            style="white-space:nowrap; min-width:200px;">
                            <i class="bi bi-arrow-left-circle"></i>
                            Kembali
                        </a>
                    </div>
                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/ckeditor4@4.19.1/ckeditor.js"></script>
    <script>
        document.querySelectorAll('textarea.word-textbox').forEach(function(textarea) {
            CKEDITOR.replace(textarea, {
                extraPlugins: 'liststyle,justify',
                toolbar: [{
                        name: 'document',
                        items: ['Source', '-', 'NewPage', 'Preview', 'Print', '-', 'Templates']
                    },
                    {
                        name: 'clipboard',
                        items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo',
                            'Redo'
                        ]
                    },
                    {
                        name: 'editing',
                        items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']
                    },
                    {
                        name: 'forms',
                        items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select',
                            'Button', 'ImageButton', 'HiddenField'
                        ]
                    },
                    '/',
                    {
                        name: 'basicstyles',
                        items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript',
                            '-', 'RemoveFormat'
                        ]
                    },
                    {
                        name: 'paragraph',
                        items: ['NumberedList', 'BulletedList', 'Outdent', 'Indent', '-', 'Blockquote',
                            'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight',
                            'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language', 'ListStyle'
                        ]
                    },
                    {
                        name: 'links',
                        items: ['Link', 'Unlink', 'Anchor']
                    },
                    {
                        name: 'insert',
                        items: ['Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar',
                            'PageBreak', 'Iframe'
                        ]
                    },
                    '/',
                    {
                        name: 'styles',
                        items: ['Styles', 'Format', 'Font', 'FontSize']
                    },
                    {
                        name: 'colors',
                        items: ['TextColor', 'BGColor']
                    },
                    {
                        name: 'tools',
                        items: ['Maximize', 'ShowBlocks']
                    },
                    {
                        name: 'about',
                        items: ['About']
                    }
                ]
            });
        });
    </script>

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
        function formatNumber(num) {
            // Format nombor dengan 2 titik perpuluhan dan koma ribu
            return num.toLocaleString('ms-MY', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function kiraJumlah() {
            const rows = document.querySelectorAll("#implikasiBody tr");
            let totalJumlah = 0,
                totalSST = 0,
                totalAkhir = 0;
            rows.forEach(row => {
                const jumlahInput = row.querySelector('input[name="jumlah[]"]');
                const sstFlag = row.querySelector('select[name="sst_flag[]"]');
                const sstCell = row.querySelector(".sst");
                const totalCell = row.querySelector(".total");
                let jumlah = parseFloat(jumlahInput?.value) || 0;
                let sst = 0;
                let sstText = '';
                if (sstFlag && sstFlag.value === "Ada") {
                    sst = jumlah * 0.08;
                    sstText = '= ' + formatNumber(sst);
                }
                if (sstCell) sstCell.textContent = sstText;
                let jumlahTermasukSST = jumlah + sst;
                if (totalCell) totalCell.textContent = formatNumber(jumlahTermasukSST);
                totalJumlah += jumlah;
                totalSST += sst;
                totalAkhir += jumlahTermasukSST;
            });
            document.getElementById("total_keseluruhan").textContent = formatNumber(totalJumlah);
            document.getElementById("sst_keseluruhan").textContent = formatNumber(totalSST);
            document.getElementById("jumlah_akhir").textContent = formatNumber(totalAkhir);
            document.getElementById("jumlah_akhir_input").value = totalAkhir.toFixed(2);
        }
        document.addEventListener('input', function(e) {
            if (e.target && (e.target.matches('input[name="jumlah[]"]') || e.target.matches(
                    'select[name="sst_flag[]"]'))) {
                kiraJumlah();
            }
        });

        function tambahBaris() {
            const tbody = document.getElementById('implikasiBody');
            const rowCount = tbody.rows.length + 1;
            const tr = document.createElement('tr');
            tr.innerHTML = `
<td class="text-center">${rowCount}</td>
<td><input type="text" name="keterangan[]" class="form-control text-center" required></td>
<td><input type="number" name="jumlah[]" class="form-control text-center" step="0.01" min="0" value="0" required></td>
<td class="text-center">
    <div class="d-flex align-items-center justify-content-center gap-2">
        <select name="sst_flag[]" class="form-select sst-flag text-center" style="width:auto" required>
            <option value="Tiada">Tiada</option>
            <option value="Ada">Ada</option>
        </select>
        <span class="sst">0.00</span>
    </div>
</td>
<td class="total text-center">0.00</td>
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
            const listDiv = document.getElementById(listId);
            let ol = listDiv.querySelector('ol');
            ol.style.display = '';
            const li = document.createElement('li');
            li.innerHTML = `
        <div class="d-flex mb-2">
            <input type="text" class="form-control me-2" name="${inputName}" required>
            <button type="button" class="btn btn-danger btn-sm" onclick="buangIsi(this)">Buang</button>
        </div>
    `;
            ol.appendChild(li);
        }

        // Ubah buangIsi supaya sembunyi <ol> jika tiada <li>
        function buangIsi(button) {
            const li = button.closest('li');
            const ol = li.parentElement;
            li.remove();
            if (ol.children.length === 0) {
                ol.style.display = 'none';
            }
        }
    </script>

    <script>
        document.querySelectorAll('textarea').forEach(function(textarea) {
            textarea.addEventListener('paste', function(e) {
                e.preventDefault();
                let text = (e.clipboardData || window.clipboardData).getData('text');
                // Remove all line breaks and extra spaces
                text = text.replace(/[\r\n]+/g, ' ').replace(/\s+/g, ' ').trim();
                // Insert cleaned text at cursor
                const start = this.selectionStart;
                const end = this.selectionEnd;
                this.value = this.value.substring(0, start) + text + this.value.substring(end);
                this.selectionStart = this.selectionEnd = start + text.length;
            });
        });
    </script>

</body>

</html>
