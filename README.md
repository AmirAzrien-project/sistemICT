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

## 🚀 Installation

1. **Clone repo**
git clone [https://github.com/AmirAzrien/SistemICT.git](https://github.com/AmirAzrien/SistemICT.git)
cd SistemICT


2. **Salin dan ubah suai `.env`**
cp .env.example .env


3. **Pasang dependensi**
composer install
npm install && npm run dev


4. **Setup database**
php artisan migrate --seed


5. **Jalankan sistem**
php artisan serve



## 🧪 Akaun Demo

Issue -> Credentials
| Jenis Pengguna | Emel            | Kata Laluan |
|----------------|------------------|--------------|
| Admin Jabatan  | admin@jpict.my   | password     |
| Pengguna Awam  | user@jpict.my    | password     |

---

Projek ini dibangunkan untuk tujuan akademik/dalaman organisasi sahaja.
- [@AmirAzrien](https://github.com/AmirAzrien) - Pembangun utama
