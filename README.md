# RideOn - Sistem Penyewaan Motor

RideOn adalah sistem penyewaan motor berbasis web yang memungkinkan pemilik motor untuk menyewakan kendaraannya dan penyewa untuk mencari serta menyewa motor dengan mudah.

## 🚀 Fitur Utama

### 1. Sistem Autentikasi
- ✅ Login & Register untuk 3 role: Penyewa, Pemilik, dan Admin
- ✅ Role-based dashboard redirect
- ✅ Middleware untuk kontrol akses

### 2. Dashboard Pemilik Motor
- ✅ Statistik motor (Total, Tersedia, Disewa, Pendapatan)
- ✅ Daftarkan motor baru dengan upload foto & dokumen
- ✅ Lihat status motor (Pending, Tersedia, Disewa, Perawatan)
- ✅ Laporan bagi hasil pendapatan
- ✅ Riwayat pendapatan dengan pagination

### 3. Dashboard Penyewa (Coming Soon)
- 🔄 Pencarian motor berdasarkan merk dan CC
- 🔄 Pemesanan dan pembayaran
- 🔄 Riwayat penyewaan
- 🔄 Status penyewaan aktif

### 4. Dashboard Admin (Coming Soon)
- 🔄 Verifikasi motor yang didaftarkan pemilik
- 🔄 Penetapan tarif sewa
- 🔄 Konfirmasi pembayaran dan penyewaan
- 🔄 Laporan sistem dan pendapatan

## 🛠 Teknologi yang Digunakan

- **Backend**: Laravel 11
- **Frontend**: Blade Templates + Tailwind CSS
- **Database**: MySQL/SQLite
- **Asset Building**: Vite
- **File Storage**: Local Storage dengan Symbolic Link

## 📊 Struktur Database

### Users Table
- id, name, email, no_tlpn, role (penyewa/pemilik/admin), password

### Motors Table  
- id, pemilik_id, merk, tipe_cc (100/125/150), no_plat, status, photo, dokumen_kepemilikan

### Tarif_Rentals Table
- id, motor_id, tarif_harian, tarif_mingguan, tarif_bulanan

### Penyewaans Table
- id, penyewa_id, motor_id, tanggal_mulai, tanggal_selesai, tipe_durasi, harga, status

### Transaksis Table
- id, pemesanan_id, jumlah, metode_pembayaran, status, tanggal

### Bagi_Hasils Table
- id, pemesanan_id, bagi_hasil_pemilik, bagi_hasil_admin, settled_at, tanggal

## 🚦 Instalasi & Setup

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL atau SQLite

### Langkah Instalasi

1. **Clone & Install Dependencies**
   ```bash
   cd d:\laragon\www\rideon
   composer install
   npm install
   ```

2. **Setup Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup**
   - Konfigurasi database di file `.env`
   - Jalankan migration:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

4. **Storage Setup**
   ```bash
   php artisan storage:link
   ```

5. **Build Assets**
   ```bash
   npm run dev  # untuk development
   npm run build  # untuk production
   ```

6. **Jalankan Server**
   ```bash
   php artisan serve
   ```

## 👥 Default Users

Setelah menjalankan seeder, Anda dapat login dengan akun berikut:

- **Admin**: admin@rideon.com / password123
- **Pemilik**: owner@rideon.com / password123  
- **Penyewa**: renter@rideon.com / password123

## 📱 Tampilan & Fitur

### Halaman Login/Register
- Form login dengan validasi
- Form register dengan pemilihan role (Penyewa/Pemilik)
- Responsive design dengan Tailwind CSS
- Redirect otomatis berdasarkan role

### Dashboard Pemilik
- **Cards Statistik**: Total motor, motor tersedia, motor disewa, total pendapatan
- **Tabel Motor**: Daftar motor dengan foto, status, dan tarif
- **Form Daftar Motor**: Upload foto, dokumen, dan data motor
- **Laporan Pendapatan**: Riwayat bagi hasil dengan detail penyewa

### Responsive Design
- Mobile-first approach
- Adaptive navigation
- Touch-friendly buttons dan forms

## 🔐 Sistem Keamanan

- **Role-based Access Control**: Middleware untuk membatasi akses berdasarkan role
- **CSRF Protection**: Laravel CSRF protection pada semua forms
- **File Upload Security**: Validasi tipe dan ukuran file
- **Password Hashing**: Bcrypt untuk enkripsi password

## 📝 Alur Sistem

### 1. Registrasi Pemilik Motor
1. Pemilik mendaftar dengan role "pemilik"
2. Login ke dashboard pemilik
3. Daftarkan motor dengan foto dan dokumen
4. Motor berstatus "Pending" menunggu verifikasi admin

### 2. Verifikasi Admin (Coming Soon)
1. Admin melihat daftar motor pending
2. Verifikasi dokumen dan foto motor
3. Tetapkan tarif sewa (harian, mingguan, bulanan)
4. Motor berubah status menjadi "Tersedia"

### 3. Penyewaan Motor (Coming Soon)
1. Penyewa search motor berdasarkan kriteria
2. Pilih motor dan durasi sewa
3. Sistem hitung biaya total
4. Proses pembayaran
5. Admin konfirmasi pembayaran
6. Motor berstatus "Disewa"

### 4. Pengembalian & Bagi Hasil (Coming Soon)
1. Setelah masa sewa habis, penyewa kembalikan motor
2. Admin konfirmasi pengembalian
3. Sistem otomatis hitung bagi hasil
4. Generate laporan untuk pemilik dan admin

## 🎨 UI/UX Design

### Color Scheme
- **Primary**: Blue (#3B82F6)
- **Secondary**: Gray (#6B7280)  
- **Success**: Green (#10B981)
- **Warning**: Yellow (#F59E0B)
- **Error**: Red (#EF4444)

### Components
- Cards dengan shadow dan border radius
- Buttons dengan hover effects
- Form inputs dengan focus states
- Status badges dengan warna sesuai status
- Loading animations
- Responsive tables
- File upload dengan drag & drop UI

## 🔄 Status Pengembangan

✅ **Selesai**:
- Autentikasi & Role Management
- Dashboard Pemilik Motor
- CRUD Motor dengan File Upload
- Database Structure & Migrations
- Basic UI dengan Tailwind CSS

🔄 **Sedang Dikembang**:
- Dashboard Admin untuk verifikasi
- Sistem penyewaan untuk penyewa
- Payment gateway integration
- Notification system
- Advanced reporting

📋 **Rencana Selanjutnya**:
- Real-time chat antara penyewa dan pemilik
- Rating & review system
- Mobile app (Flutter/React Native)
- GPS tracking motor
- Integration dengan e-wallet

## 🤝 Kontribusi

Proyek ini dikembangkan untuk keperluan ujian kompetensi. Untuk kontribusi atau pertanyaan, silakan hubungi developer.

## 📄 License

Proyek ini menggunakan license MIT. Silakan gunakan dan modifikasi sesuai kebutuhan.

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
