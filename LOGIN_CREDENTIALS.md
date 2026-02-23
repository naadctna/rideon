# 🔐 RideOn - Informasi Login

## 👤 **Akun Default yang Sudah Dibuat**

### 🛡️ **ADMIN**
```
Email    : admin@rideon.com
Password : password123
Role     : admin
```

### 🏍️ **PEMILIK MOTOR (Owner)**
```
Email    : owner@rideon.com
Password : password123
Role     : pemilik
```

### 👤 **PENYEWA (Renter)**
```
Email    : renter@rideon.com
Password : password123
Role     : penyewa
```

---

## 🎯 **Cara Login:**

1. **Buka:** http://127.0.0.1:8000/login
2. **Masukkan email & password** sesuai role yang diinginkan
3. **Otomatis redirect** ke dashboard sesuai role:
   - Admin → `/admin/dashboard`
   - Pemilik → `/owner/dashboard`
   - Penyewa → `/renter/dashboard`

---

## 🔧 **Cara Membuat User Baru:**

### Via Register (untuk Penyewa):
- Kunjungi: http://127.0.0.1:8000/register
- Isi form registrasi (otomatis role = penyewa)

### Via Database Manual:
```php
// Masuk ke tinker
php artisan tinker

// Buat admin baru
User::create([
    'name' => 'Nama Admin',
    'email' => 'admin2@rideon.com',
    'password' => bcrypt('password123'),
    'role' => 'admin',
    'no_tlpn' => '08123456789'
]);

// Buat pemilik baru
User::create([
    'name' => 'Nama Pemilik',
    'email' => 'pemilik2@rideon.com', 
    'password' => bcrypt('password123'),
    'role' => 'pemilik',
    'no_tlpn' => '08123456790'
]);
```

---

## 📱 **Informasi Kontak Default:**
- **Admin:** 08123456789
- **Owner:** 08123456790
- **Renter:** 08123456791

---

## 🚀 **Fitur per Role:**

### **Admin:**
- ✅ Verifikasi motor
- ✅ Kelola penyewaan
- ✅ Lihat laporan & revenue
- ✅ Monitor distribusi pendapatan (30%)

### **Pemilik Motor:**
- ✅ Tambah motor baru
- ✅ Kelola motor milik sendiri
- ✅ Lihat booking aktif
- ✅ Kontak penyewa (WhatsApp/telepon)
- ✅ Lihat pendapatan (70% dari sewa)

### **Penyewa:**
- ✅ Browse & filter motor
- ✅ Booking motor dengan pembayaran otomatis
- ✅ Lihat history sewa
- ✅ Dashboard statistik

---

**🎉 Semua akun menggunakan password yang sama: `password123`**