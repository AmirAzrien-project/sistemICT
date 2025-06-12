# Permohonan Projek JPICT 🖥️📄

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

Berikut terjemahan penuh dalam Bahasa Melayu ringkas untuk dimasukkan ke dalam README atau panduan pemasangan:

````
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

```bash
php artisan migrate --seed
```

Arahan ini akan cipta semua jadual dan isikan data contoh untuk sistem berfungsi dengan betul.

### 5. Jalankan Aplikasi

Akhir sekali, jalankan 'local server' untuk guna SistemICT di pelayar web.

```bash
php artisan serve
```

Selepas server berjalan, satu pautan seperti `http://127.0.0.1:8000` akan dipaparkan. **Buka pautan itu di pelayar web anda** untuk mula guna aplikasi SistemICT.

---

## 🧪 Akaun Demo

Issue -> Credentials
| Jenis Pengguna | Emel            | Kata Laluan |
|----------------|------------------|--------------|
| Admin Jabatan  | admin@jpict.my   | password     |
| Pengguna Awam  | user@jpict.my    | password     |

---

Projek ini dibangunkan untuk tujuan akademik/dalaman organisasi sahaja.
- [@AmirAzrien](https://github.com/AmirAzrien) - Pembangun utama
