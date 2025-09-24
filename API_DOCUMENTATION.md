# RideOn API Documentation

API REST untuk sistem penyewaan motor RideOn.

## Base URL
```
http://localhost:8000
```

## Authentication
Sistem menggunakan Laravel Session Authentication untuk web interface.

## API Endpoints

### 1. Authentication

#### POST /auth/register
Mendaftarkan akun baru

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "no_tlpn": "08123456789",
    "role": "pemilik" // atau "penyewa"
}
```

**Response:**
```json
{
    "message": "Registration successful",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "pemilik"
    }
}
```

#### POST /auth/login
Login ke sistem

**Request Body:**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response:**
```json
{
    "message": "Login successful",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "role": "pemilik"
    },
    "redirect": "/owner/dashboard"
}
```

### 2. Pemilik Motor (Owner)

#### POST /owner/motors
Mendaftarkan motor baru (Form Data)

**Headers:**
```
Content-Type: multipart/form-data
```

**Request Body:**
```
merk: Honda Beat
tipe_cc: 125
no_plat: D 1234 ABC
photo: [file]
dokumen_kepemilikan: [file]
```

**Response:**
```json
{
    "message": "Motor berhasil didaftarkan",
    "motor": {
        "id": 1,
        "merk": "Honda Beat",
        "tipe_cc": "125",
        "no_plat": "D 1234 ABC",
        "status": "pending",
        "photo": "motor_photos/123456.jpg",
        "dokumen_kepemilikan": "motor_documents/123456.pdf"
    }
}
```

#### GET /owner/motors
Melihat daftar motor milik owner

**Response:**
```json
{
    "data": [
        {
            "id": 1,
            "merk": "Honda Beat",
            "tipe_cc": "125",
            "no_plat": "D 1234 ABC",
            "status": "tersedia",
            "photo": "motor_photos/123456.jpg",
            "tarif_rental": {
                "tarif_harian": 50000,
                "tarif_mingguan": 300000,
                "tarif_bulanan": 1000000
            }
        }
    ]
}
```

#### GET /owner/revenue
Melihat laporan bagi hasil

**Response:**
```json
{
    "total_revenue": 2500000,
    "data": [
        {
            "id": 1,
            "tanggal": "2025-09-20",
            "bagi_hasil_pemilik": 150000,
            "bagi_hasil_admin": 50000,
            "settled_at": "2025-09-21T10:00:00Z",
            "penyewaan": {
                "penyewa": {
                    "name": "Jane Doe",
                    "email": "jane@example.com"
                },
                "motor": {
                    "merk": "Honda Beat",
                    "no_plat": "D 1234 ABC"
                },
                "tanggal_mulai": "2025-09-15",
                "tanggal_selesai": "2025-09-20",
                "tipe_durasi": "harian"
            }
        }
    ],
    "pagination": {
        "current_page": 1,
        "total_pages": 5,
        "per_page": 10
    }
}
```

### 3. Penyewa (Renter) - Coming Soon

#### GET /motors
Melihat daftar motor tersedia

**Query Parameters:**
- `merk`: Filter berdasarkan merk motor
- `tipe_cc`: Filter berdasarkan tipe CC (100, 125, 150)
- `page`: Halaman pagination

**Response:**
```json
{
    "data": [
        {
            "id": 1,
            "merk": "Honda Beat",
            "tipe_cc": "125",
            "status": "tersedia",
            "photo": "motor_photos/123456.jpg",
            "pemilik": {
                "name": "John Doe"
            },
            "tarif_rental": {
                "tarif_harian": 50000,
                "tarif_mingguan": 300000,
                "tarif_bulanan": 1000000
            }
        }
    ]
}
```

#### POST /bookings
Membuat pemesanan motor

**Request Body:**
```json
{
    "motor_id": 1,
    "tanggal_mulai": "2025-09-25",
    "tanggal_selesai": "2025-09-30",
    "tipe_durasi": "harian"
}
```

**Response:**
```json
{
    "message": "Pemesanan berhasil dibuat",
    "booking": {
        "id": 1,
        "motor_id": 1,
        "tanggal_mulai": "2025-09-25",
        "tanggal_selesai": "2025-09-30",
        "tipe_durasi": "harian",
        "harga": 250000,
        "status": "pending"
    }
}
```

#### POST /payments
Melakukan pembayaran

**Request Body:**
```json
{
    "booking_id": 1,
    "jumlah": 250000,
    "metode_pembayaran": "transfer"
}
```

#### GET /bookings/history
Melihat riwayat pemesanan

### 4. Admin - Coming Soon

#### PATCH /admin/motors/:id/verify
Verifikasi motor yang didaftarkan

**Request Body:**
```json
{
    "status": "tersedia", // atau "ditolak"
    "tarif_harian": 50000,
    "tarif_mingguan": 300000,
    "tarif_bulanan": 1000000,
    "catatan": "Motor telah diverifikasi"
}
```

#### PATCH /admin/bookings/:id/confirm
Konfirmasi pemesanan

**Request Body:**
```json
{
    "status": "confirmed", // atau "rejected"
    "catatan": "Pembayaran telah dikonfirmasi"
}
```

#### GET /admin/reports/revenue
Laporan pendapatan dan bagi hasil

**Response:**
```json
{
    "total_pendapatan": 5000000,
    "bagi_hasil_pemilik": 3500000,
    "bagi_hasil_admin": 1500000,
    "jumlah_motor_terdaftar": 50,
    "jumlah_motor_disewa": 25,
    "data_bulanan": [
        {
            "bulan": "2025-09",
            "pendapatan": 2500000,
            "jumlah_transaksi": 15
        }
    ]
}
```

## Error Responses

### 400 Bad Request
```json
{
    "message": "Validation failed",
    "errors": {
        "email": ["The email field is required"],
        "password": ["The password must be at least 6 characters"]
    }
}
```

### 401 Unauthorized
```json
{
    "message": "Unauthenticated"
}
```

### 403 Forbidden
```json
{
    "message": "Access denied. You do not have permission to access this page."
}
```

### 404 Not Found
```json
{
    "message": "Resource not found"
}
```

### 422 Unprocessable Entity
```json
{
    "message": "The given data was invalid",
    "errors": {
        "no_plat": ["The no plat has already been taken"]
    }
}
```

## Status Codes

- `200` - OK
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Unprocessable Entity
- `500` - Internal Server Error

## File Upload Specifications

### Motor Photo
- **Allowed formats**: JPEG, PNG, JPG
- **Max size**: 2MB
- **Storage path**: `storage/app/public/motor_photos/`

### Motor Document
- **Allowed formats**: PDF, JPEG, PNG, JPG
- **Max size**: 2MB
- **Storage path**: `storage/app/public/motor_documents/`

## Rate Limiting

API endpoints dibatasi untuk:
- 60 requests per minute untuk authenticated users
- 20 requests per minute untuk guest users

## Pagination

Semua endpoint yang mengembalikan list data menggunakan pagination:

```json
{
    "data": [...],
    "links": {
        "first": "http://localhost:8000/api/endpoint?page=1",
        "last": "http://localhost:8000/api/endpoint?page=10",
        "prev": null,
        "next": "http://localhost:8000/api/endpoint?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 10,
        "per_page": 15,
        "to": 15,
        "total": 150
    }
}
```