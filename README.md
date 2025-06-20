# Permohonan Kelulusan Projek JPICT 🖥️📄

Sistem ini dibangunkan untuk memudahkan proses permohonan projek ICT melalui Jawatankuasa Projek ICT (JPICT).
Ia direka khas untuk pengguna dalam sektor kerajaan bagi memohon, mengurus dan menyemak status projek ICT yang dicadangkan.

---

## 📁 Ciri-ciri Sistem

- ✅ Permohonan projek ICT (Pembangunan Sistem, Perisian, Perkakasan, dll.)
- 🗂️ Pengurusan permohonan oleh admin & sekretariat
- 📄 Penjanaan dokumen automatik (PDF)
- 📊 Status permohonan: Dalam Proses, Disyorkan, Tidak Disyorkan
- 🗓️ Modul mesyuarat JPICT (Jabatan & Negeri)

---

## 🛠️ Teknologi Digunakan

- PHP (Laravel)
- MySQL / MariaDB
- HTML + Bootstrap 5
- JavaScript (jQuery)
- Git + GitHub (version control)

---


# 🚀 Panduan Pemasangan SistemICT

### 1. Clone Repository

Muat turun kod aplikasi dari GitHub.

```bash
git clone https://github.com/AmirAzrien/SistemICT.git
cd SistemICT
````

### 2. Tetapkan Fail Persekitaran

Aplikasi ini menggunakan fail `.env` untuk tetapan seperti sambungan ke pangkalan data.

```bash
cp .env.example .env
```

Selepas salin, **buka fail `.env`** menggunakan editor pilihan anda. Tukar maklumat seperti `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` supaya sesuai dengan pangkalan data anda. Simpan fail selepas ubah suai.

### 3. Pasang Keperluan Projek

SistemICT bergantung pada 'library' PHP dan Node.js tertentu.

```bash
composer install
npm install && npm run dev
```

* `composer install` akan pasang semua keperluan PHP.
* `npm install && npm run dev` pula akan pasang keperluan frontend dan bina fail CSS/JS.

### 4. Sediakan Pangkalan Data

Sediakan pangkalan data dan masukkan data asas.
* Semak file DatabaseSeeder.php sebelum mula proses migration.
```bash
php artisan migrate
php artisan db:seed
```

Arahan ini akan cipta semua jadual dan isikan data contoh untuk sistem berfungsi dengan betul.

### 5. Jalankan Aplikasi

Akhir sekali, jalankan 'local server' untuk guna SistemICT di pelayar web.

```bash
php artisan serve (or npm start)
```

Selepas server berjalan, satu pautan seperti `http://127.0.0.1:8000` akan dipaparkan. **Buka pautan itu di 'browser' anda** untuk mula guna aplikasi SistemICT.

---

## 🧪 Akaun Demo

Sila semak (Issue -> Credentials) untuk menggunakan data demo.

| Jenis Pengguna | Emel                       | Kata Laluan |
|----------------|----------------------------|-------------|
| Pengguna Awam  | user.biasa@johor.gov.my    | password    |
| Sekretariat    | user.sek@johor.gov.my      | password    |
| Admin Jabatan  | user.admin@johor.gov.my    | password    |
| Super Admin    | user.super@johor.gov.my    | password    |

---

## Projek ini dibangunkan untuk tujuan akademik/dalaman organisasi sahaja.
