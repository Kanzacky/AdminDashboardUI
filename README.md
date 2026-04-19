# 🖥️ Admin Dashboard UI

Sebuah antarmuka (*User Interface*) Dashboard Admin modern dan responsif yang dibangun menggunakan **Laravel**. Proyek ini bertujuan untuk menyediakan kerangka dasar (*template*) dashboard yang bersih, terstruktur, dan siap digunakan untuk mempercepat pengembangan aplikasi web Anda.

## 🚀 Fitur Utama
- **Desain Responsif:** Tampilan yang dioptimalkan dengan baik untuk berbagai ukuran layar (Desktop, Tablet, dan Mobile).
- **Berbasis Laravel:** Dibangun di atas *framework* PHP Laravel yang tangguh dan aman.
- **Blade Templating:** Menggunakan sistem *templating* Blade sehingga modifikasi antarmuka menjadi sangat mudah.
- **Mudah Dikustomisasi:** Struktur folder, *routing*, dan aset diatur secara rapi agar mudah dikembangkan lebih lanjut.

## 🛠️ Teknologi yang Digunakan
- **[Laravel](https://laravel.com/)** (PHP Framework)
- **Blade Template Engine**
- **HTML, CSS, & JavaScript**
- **Vite** (*Asset Bundler*)

## 💻 Cara Instalasi (Lokal)

Jika Anda ingin menjalankan proyek ini secara lokal, ikuti langkah-langkah berikut:

1. **Clone repositori ini:**
   ```bash
   git clone https://github.com/Kanzacky/AdminDashboardUI.git
   cd AdminDashboardUI
   ```

2. **Install dependensi PHP:**
   ```bash
   composer install
   ```

3. **Install dependensi *Front-end*:**
   ```bash
   npm install
   npm run build
   ```

4. **Konfigurasi *Environment*:**
   Salin file `.env.example` menjadi `.env`, kemudian buat *Application Key*.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Jalankan *development server*:**
   ```bash
   php artisan serve
   ```
   *Buka browser dan akses aplikasi melalui `http://localhost:8000`.*

---
*Dibuat oleh [Kanzacky](https://github.com/Kanzacky)*
