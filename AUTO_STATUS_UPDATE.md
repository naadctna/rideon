# Sistem Auto-Update Status Penyewaan

## Deskripsi
Sistem ini secara otomatis mengubah status penyewaan dan motor ketika tanggal selesai sewa sudah lewat.

## Cara Kerja

### 1. Method `Penyewaan::updateExpiredRentals()`
Located: `app/Models/Penyewaan.php`

Method ini akan:
- Mencari semua penyewaan dengan status `active`
- Yang tanggal selesainya sudah lewat dari hari ini
- Mengubah status penyewaan menjadi `completed`
- Mengubah status motor menjadi `tersedia`

### 2. Auto-trigger di Controllers

Method `updateExpiredRentals()` dipanggil otomatis di:

- **AdminController::dashboard()** - Saat admin membuka dashboard
- **AdminController::rentalManagement()** - Saat admin membuka halaman rental management
- **RenterController::dashboard()** - Saat penyewa membuka dashboard
- **OwnerController::dashboard()** - Saat pemilik membuka dashboard

Ini memastikan status selalu ter-update setiap kali ada user yang mengakses halaman-halaman utama.

### 3. Command Manual (Opsional)

Anda juga bisa menjalankan update manual via command:

```bash
php artisan rentals:update-expired
```

## Contoh Skenario

**Sebelum:**
- Tanggal selesai: 10 Feb 2026
- Tanggal sekarang: 11 Feb 2026
- Status penyewaan: `active`
- Status motor: `disewa`

**Sesudah auto-update:**
- Status penyewaan: `completed`
- Status motor: `tersedia`

## Status yang Digunakan

### Status Penyewaan:
- `pending` - Menunggu persetujuan
- `approved` - Disetujui, menunggu pembayaran
- `active` - Sedang berlangsung
- `completed` - Selesai (auto-update)
- `cancelled` - Dibatalkan

### Status Motor:
- `pending` - Menunggu verifikasi admin
- `tersedia` - Tersedia untuk disewa
- `disewa` - Sedang disewa
- `perawatan` - Dalam perawatan

## Testing

Untuk testing:
1. Buat penyewaan dengan tanggal selesai kemarin
2. Set status penyewaan ke `active`
3. Set status motor ke `disewa`
4. Akses salah satu halaman dashboard
5. Status akan otomatis ter-update

## Notes

- Update berjalan secara real-time saat user mengakses halaman
- Tidak perlu scheduler/cron job karena sudah auto-trigger
- Performa tetap baik karena hanya query penyewaan yang expired
- Transaction safe dengan database rollback jika error
