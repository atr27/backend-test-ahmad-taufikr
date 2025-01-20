# API Pencarian Data Mahasiswa

Project REST API ini berbasis Laravel yang menyediakan endpoint untuk mencari dan mengelola data mahasiswa. Project ini mengambil data dari link API eksternal, menyimpannya dalam cache untuk kinerja, dan menyediakan beberapa endpoint pencarian dengan autentikasi.

## Link Download File SQL Database
- [Link Download](https://drive.google.com/file/d/1bxe-y8Ium-B8zqlPb5HxzZJ9vAz4BKIH/view?usp=sharing)

## Fitur

- Autentikasi berbasis JWT
- Manajemen User (operasi CRUD)
- Pencarian Data Mahasiswa berdasarkan:
  - Nama
  - Nomor Induk Mahasiswa (NIM)
  - Tanggal (format YMD)
- Data Caching untuk meningkatkan kinerja
- Autentikasi Sanctum untuk keamanan API

## Yang Diinstal dan Alat Bantu Konfigurasi

- PHP >= 8.2
- Composer
- Laravel 11.x
- MySQL/PostgreSQL

## Instalasi

1. Kloning repositori:
```bash
git clone <repository-url> <repository-url>
cd backend-test-ahmadtr
```

2. Instal dependensi:
```bash
composer install
```

3. Menyiapkan variabel lingkungan:
```bash
cp .env.example .env
```
Perbarui berkas `.env` dengan kredensial basis data dan pengaturan konfigurasi lainnya.

4. Membuat kunci aplikasi:
```bash
php artisan key:generate
```

5. Jalankan migrasi basis data:
```bash
php artisan migrate
```

6. Mulai server pengembangan:
```bash
php artisan serve
```

## Endpoint API

### Autentikasi
- `POST /api/login` - Login user

### Manajemen User (Rute yang Terproteksi)
- `GET /api/users` - Daftar semua user
- `POST /api/users` - Membuat user baru
- `GET /api/users/{id}` - Dapatkan detail user
- `PUT /api/users/{id}` - Memperbarui user
- `DELETE /api/users/{id}` - Menghapus user

### Cari Endpoint (Rute yang Terproteksi)
- `GET /api/search/nama/{nama}` - Mencari siswa berdasarkan nama
- `GET /api/search/nim/{nim}` - Mencari siswa berdasarkan Nomor Induk Siswa
- `GET /api/search/ymd/{ymd}` - Mencari mahasiswa berdasarkan tanggal

## Autentikasi

API menggunakan Laravel Sanctum untuk autentikasi. Untuk mengakses rute yang perlu autentikasi:

1. Dapatkan token dengan masuk melalui endpoint `/api/login`
2. Sertakan token dalam permintaan berikutnya menggunakan header `Authorization`:
```
Otorisasi: Pembawa <token User Login>
```

## Caching

Project REST API ini mengimplementasikan caching untuk sumber data eksternal dengan batas waktu 1 jam untuk mengoptimalkan kinerja dan mengurangi panggilan API eksternal.

## Penanganan Kesalahan

API mengembalikan kode status HTTP yang sesuai:
- 200: Sukses
- 400: Permintaan Buruk
- 401: Tidak Sah
- 404: Tidak Ditemukan
- 500: Kesalahan Server

## Pengembangan

## Menjalankan Pengujian
```bash
php artisan serve
```

## Keamanan

- Semua endpoint API (kecuali login) dilindungi dengan autentikasi
- Validasi input user diimplementasikan untuk semua endpoint
- Data di-cache dengan aman

