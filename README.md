# EventSekolah

## Sistem Pengelolaan Event Sekolah

EventSekolah adalah aplikasi web untuk mengelola event sekolah secara terpusat, mulai dari publikasi event, pendaftaran peserta, pengelolaan kategori, hingga pemantauan status pendaftaran.

## Fitur Utama

### Landing Page

- Menampilkan event yang pendaftarannya masih terbuka.
- Menyembunyikan event yang sudah penuh atau tidak lagi berstatus `upcoming`.
- Search event berdasarkan judul, lokasi, dan deskripsi.
- Filter event berdasarkan kategori.
- Pagination 8 event per halaman.
- Informasi kategori, jadwal, lokasi, pengelola, dan kapasitas event.
- Halaman detail event.

### Authentication

- Register akun peserta dan pengelola.
- Login dan logout.
- Reset password.
- Konfirmasi password.
- Verifikasi email.
- Redirect berdasarkan role:
	- Admin ke dashboard admin.
	- Pengelola ke dashboard pengelola.
	- Peserta ke landing page.

### Pendaftaran Event

- Peserta dapat mendaftar ke event yang masih terbuka.
- Validasi status event dan kapasitas peserta.
- Pencegahan pendaftaran ganda melalui validasi aplikasi dan unique constraint database.
- Status pendaftaran: `pending`, `approved`, `rejected`, dan `canceled`.
- Peserta dapat melihat riwayat pendaftaran.
- Peserta dapat membatalkan pendaftaran yang masih `pending`.

### Dashboard Peserta

- Melihat ringkasan jumlah pendaftaran.
- Melihat pendaftaran terbaru.
- Melihat status pendaftaran.
- Search dan filter riwayat pendaftaran.
- Mengubah profil dan password.

### Dashboard Pengelola

- Melihat ringkasan event dan pendaftaran.
- CRUD event.
- CRUD kategori.
- Search, filter, dan pagination event.
- Melihat peserta berdasarkan event.
- Search dan filter peserta.
- Mengubah status pendaftaran peserta.
- Mengelola profil.

### Dashboard Admin

- Melihat statistik keseluruhan sistem.
- CRUD user.
- CRUD kategori.
- CRUD event seluruh pengelola.
- Melihat dan mengelola pendaftaran event.
- Search, filter, dan pagination pada data user, kategori, event, dan peserta.

## Role dan Hak Akses

| Role | Hak Akses |
| --- | --- |
| **Admin** | Mengelola user, kategori, event, dan seluruh data pendaftaran. Memiliki akses penuh terhadap data sistem. |
| **Pengelola** | Mengelola event dan kategori miliknya, melihat peserta pada event miliknya, serta memperbarui status pendaftaran. |
| **Peserta** | Melihat event terbuka, mendaftar event, melihat riwayat dan status pendaftaran, serta mengelola profil sendiri. |

Pembatasan akses diterapkan menggunakan:

- Authentication middleware.
- Custom `role` middleware.
- Validasi kepemilikan event pada controller.
- Authorization pada proses pengelolaan data.

## Teknologi

### Backend

- PHP `^8.3`.
- Laravel `^13.17`.
- Laravel Eloquent ORM.
- Laravel Blade.
- SQLite sebagai database default lokal.
- Laravel Form Request untuk validasi kompleks.
- Laravel Pest untuk testing.

### Frontend

- Blade Templates.
- Tailwind CSS.
- Alpine.js.
- Vite.
- Laravel Vite Plugin.

### Development Tools

- Laravel Breeze untuk authentication scaffolding.
- Laravel Boost untuk bantuan pengembangan Laravel.
- Laravel Debugbar untuk inspeksi query dan request saat development.
- Faker untuk factory dan data dummy.

## Persyaratan Sistem

Pastikan perangkat sudah memiliki:

- PHP 8.3 atau lebih baru.
- Composer.
- Node.js dan npm.
- SQLite atau database lain yang didukung Laravel.
- Git, jika project diambil dari repository.

Untuk pengguna Windows, project dapat dijalankan menggunakan Laragon.

## Cara Menjalankan Project

### 1. Clone Repository

```bash
git clone <url-repository>
cd STS_SistemPengelolaanEvent
```

### 2. Install Dependency PHP

```bash
composer install
```

### 3. Install Dependency Frontend

```bash
npm install
```

### 4. Siapkan File Environment

```bash
copy .env.example .env
```

Pada macOS/Linux, gunakan:

```bash
cp .env.example .env
```

Kemudian buat application key:

```bash
php artisan key:generate
```

### 5. Konfigurasi Database

Konfigurasi default menggunakan SQLite. Pastikan file database tersedia:

```bash
if not exist database\database.sqlite type nul > database\database.sqlite
```

Atau buat file `database/database.sqlite` secara manual, lalu pastikan `.env` berisi:

```env
DB_CONNECTION=sqlite
```

Jika menggunakan MySQL, sesuaikan nilai `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` pada `.env`.

### 6. Jalankan Migration dan Seeder

Untuk membuat database dari awal sekaligus mengisi data demo:

```bash
php artisan migrate:fresh --seed
```

Seeder akan membuat:

- User demo untuk setiap role.
- 5 kategori event.
- 30 event, termasuk event yang dibuat melalui `EventFactory`.
- Data pendaftaran contoh.

### 7. Jalankan Asset Frontend

Untuk development dengan hot reload:

```bash
npm run dev
```

Untuk membuat asset production:

```bash
npm run build
```

### 8. Jalankan Server Laravel

Pada terminal lain:

```bash
php artisan serve
```

Buka aplikasi melalui:

```text
http://127.0.0.1:8000
```

## Akun Demo

Semua akun demo menggunakan password:

```text
password
```

| Role | Email |
| --- | --- |
| Admin | `admin@sts.id` |
| Pengelola | `pengelola@sts.id` |
| Pengelola | `pengelola2@sts.id` |
| Peserta | `peserta@sts.id` |
| Peserta | `peserta2@sts.id` |
| Peserta | `peserta3@sts.id` |

## Testing

Jalankan seluruh test:

```bash
php artisan test
```

Atau gunakan script Composer:

```bash
composer test
```

Test mencakup authentication, registrasi, profil, password, dan alur aplikasi utama.

## Struktur Folder Penting

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   ├── Auth/
│   │   ├── Pengelola/
│   │   └── Peserta/
│   ├── Middleware/
│   └── Requests/
├── Models/
└── Providers/

database/
├── factories/
├── migrations/
└── seeders/

resources/
├── css/
├── js/
└── views/
		├── admin/
		├── auth/
		├── pengelola/
		├── peserta/
		└── profile/

routes/
├── auth.php
├── console.php
└── web.php
```

## Validasi dan Keamanan

- Form dengan validasi kompleks menggunakan FormRequest.
- Validasi sederhana tetap berada di controller agar tetap proporsional.
- Password disimpan menggunakan hashing Laravel.
- Route dashboard dilindungi middleware authentication dan role.
- Peserta hanya dapat mengelola pendaftaran miliknya sendiri.
- Pengelola hanya dapat mengelola event dan peserta pada event miliknya.
- Admin memiliki akses sistem sesuai kebutuhan administrasi.
- Unique constraint pada kombinasi `user_id` dan `event_id` mencegah duplikasi pendaftaran.

## Perintah Artisan yang Sering Digunakan

```bash
# Menampilkan daftar route
php artisan route:list

# Membersihkan cache aplikasi
php artisan optimize:clear

# Membuat migration
php artisan make:migration nama_migration

# Membuat model dan factory
php artisan make:model NamaModel -mf

# Membuat FormRequest
php artisan make:request NamaRequest

# Mengulang database dan data demo
php artisan migrate:fresh --seed
```

## Lisensi

Project ini menggunakan Laravel yang dirilis di bawah [MIT License](https://opensource.org/licenses/MIT). Ketentuan penggunaan project dapat disesuaikan dengan kebutuhan pengembangan aplikasi.
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>
