# Halaman Detail Verifikasi Motor

## Deskripsi
Halaman detail verifikasi motor adalah halaman khusus yang menampilkan informasi lengkap tentang motor yang akan diverifikasi oleh admin. Halaman ini memberikan pandangan komprehensif sebelum admin melakukan approve atau reject terhadap motor yang didaftarkan pemilik.

## URL & Route
- **URL**: `/admin/motor-verification/{id}`
- **Route Name**: `admin.motor-verification.detail`
- **Method**: GET
- **Controller**: `AdminController@motorVerificationDetail`

## Fitur Utama

### 1. Informasi Motor Lengkap
- **Foto Motor**: Tampilan besar foto motor yang didaftarkan
- **Spesifikasi**:
  - Merk Motor
  - Tipe CC (100cc, 125cc, 150cc)
  - Nomor Plat
  - Deskripsi (jika ada)
  - Dokumen Kepemilikan (dengan link download)
  - Tanggal Pendaftaran
  - Status Motor

### 2. Informasi Tarif Rental
Menampilkan tarif yang sudah ditetapkan (jika ada):
- Tarif Harian
- Tarif Mingguan (7 hari)
- Tarif Bulanan (30 hari)

Jika tarif belum ditetapkan, akan muncul notifikasi bahwa tarif akan diset saat approve.

### 3. Statistik Motor
Dashboard card yang menampilkan:
- **Total Penyewaan**: Jumlah total kali motor pernah disewa
- **Sedang Disewa**: Jumlah penyewaan yang sedang aktif
- **Selesai**: Jumlah penyewaan yang sudah selesai
- **Total Pendapatan**: Akumulasi pendapatan dari motor ini

### 4. Informasi Pemilik
Panel khusus yang menampilkan:
- Nama Pemilik
- Email
- Nomor Telepon
- Alamat (jika ada)
- Tanggal Bergabung
- Statistik:
  - Total Motor yang dimiliki
  - Motor yang aktif/tersedia

### 5. Riwayat Penyewaan
Tabel lengkap riwayat penyewaan motor (jika ada):
- Nama Penyewa
- Email Penyewa
- Tanggal Mulai & Selesai
- Durasi (dalam hari)
- Total Harga
- Status Penyewaan

### 6. Aksi Verifikasi

#### Untuk Motor Pending:
**Approve Button**:
- Membuka modal untuk set tarif (jika belum ada)
- Atau langsung approve dengan tarif yang sudah ada
- Mengubah status motor menjadi "tersedia"

**Reject Button**:
- Membuka modal untuk input alasan penolakan
- Mengubah status motor menjadi "rejected"
- Alasan penolakan disimpan untuk referensi pemilik

#### Untuk Motor Tersedia:
- Menampilkan badge "Motor Sudah Diverifikasi"
- Tidak ada tombol aksi

#### Untuk Motor Rejected:
- Menampilkan badge "Motor Ditolak"
- Menampilkan alasan penolakan

### 7. Catatan Verifikasi
Panduan checklist untuk admin:
- ✓ Periksa kelengkapan dokumen kepemilikan
- ✓ Verifikasi kesesuaian foto dengan spesifikasi
- ✓ Pastikan tarif rental sesuai dengan kondisi motor
- ✓ Hubungi pemilik jika ada informasi yang kurang jelas

## Modal Dialog

### Approve Modal
Form untuk menyetujui motor dengan field:
- **Tarif Harian** (Rp) - required, min: 10,000
- **Tarif Mingguan** (Rp) - required, min: 50,000
- **Tarif Bulanan** (Rp) - required, min: 100,000

Jika tarif sudah ada, akan menampilkan tarif yang sudah ditetapkan.

### Reject Modal
Form untuk menolak motor dengan field:
- **Alasan Penolakan** (textarea) - required
- Placeholder: "Jelaskan alasan penolakan verifikasi..."

## Flow Penggunaan

1. Admin mengakses halaman motor verification: `/admin/motor-verification`
2. Admin melihat list motor yang pending
3. Admin klik tombol **"Lihat Detail Lengkap"** pada motor yang ingin diverifikasi
4. Sistem redirect ke `/admin/motor-verification/{id}`
5. Admin mereview semua informasi:
   - Foto motor
   - Spesifikasi lengkap
   - Dokumen kepemilikan
   - Informasi pemilik
   - Statistik (jika motor pernah disewa sebelumnya)
6. Admin memutuskan:
   - **APPROVE**: Klik tombol hijau "Approve Motor"
     - Isi tarif rental (jika belum ada)
     - Submit form
     - Motor menjadi tersedia untuk disewa
   - **REJECT**: Klik tombol merah "Reject Motor"
     - Isi alasan penolakan
     - Submit form
     - Motor menjadi rejected dengan alasan tersimpan

## Database Changes

### Migration Files Created:
1. `2026_01_22_110546_add_rejection_reason_and_deskripsi_to_motors_table.php`
   - Menambahkan kolom `rejection_reason` (text, nullable)
   - Menambahkan kolom `deskripsi` (text, nullable)

2. `2026_01_22_110642_update_motor_status_enum.php`
   - Update enum `status` untuk menambahkan 'rejected' dan 'maintenance'
   - Status: pending, tersedia, disewa, perawatan, rejected, maintenance

### Model Update:
File: `app/Models/Motor.php`
- Menambahkan `rejection_reason` dan `deskripsi` ke `$fillable`

## Files Created/Modified

### New Files:
1. `resources/views/admin/motor-verification-detail.blade.php`
   - View utama untuk halaman detail verifikasi motor

### Modified Files:
1. `routes/web.php`
   - Menambahkan route: `GET /admin/motor-verification/{id}`

2. `app/Http/Controllers/AdminController.php`
   - Menambahkan method `motorVerificationDetail($id)`

3. `resources/views/admin/motor-verification.blade.php`
   - Mengubah tombol "Lihat Detail Lengkap" dari modal menjadi link ke halaman detail

4. `app/Models/Motor.php`
   - Menambahkan field baru ke fillable

## Teknologi & Styling
- **Framework**: Laravel 11
- **Frontend**: Blade Template
- **CSS**: Tailwind CSS
- **Icons**: Heroicons (SVG)
- **Interaksi**: Vanilla JavaScript
- **Responsive**: Mobile-friendly dengan grid system

## Security
- Route dilindungi dengan middleware `auth` dan `role:admin`
- CSRF protection pada semua form
- Input validation pada controller
- XSS protection melalui Blade escaping

## Best Practices Implemented
✅ Separation of concerns (view terpisah untuk detail)
✅ Responsive design
✅ User-friendly UI dengan visual feedback
✅ Informasi komprehensif untuk decision making
✅ Clear action buttons dengan warna semantik
✅ Modal confirmation untuk aksi penting
✅ Loading states dan error handling

## Testing
Untuk test fitur ini:
1. Login sebagai admin
2. Pastikan ada motor dengan status 'pending'
3. Akses `/admin/motor-verification`
4. Klik "Lihat Detail Lengkap" pada salah satu motor
5. Periksa semua informasi ditampilkan dengan benar
6. Test tombol Approve dan Reject
7. Verifikasi perubahan status di database

## Notes
- Halaman ini dirancang untuk memberikan admin semua informasi yang dibutuhkan dalam satu tampilan
- Statistik motor membantu admin memahami performa motor (jika sudah pernah disewa)
- Riwayat penyewaan membantu assess reliability motor
- Informasi pemilik lengkap memudahkan admin untuk follow-up jika diperlukan
