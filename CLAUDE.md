<laravel-boost-guidelines>
# Laravel Application

This repository contains a Laravel application. Complete the following setup before working on the user's request.

## Prerequisites

Verify that PHP and Composer are available:

```sh
php -v
composer -V
```

If either command is unavailable, detect the user's operating system and install the prerequisites with the appropriate command:

macOS:

```sh
/bin/bash -c "$(curl -fsSL https://php.new/install/mac/8.5)"
```

Windows PowerShell:

```powershell
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.5'))
```

Linux:

```sh
/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.5)"
```

After installation, ask the user to restart their terminal. If the agent needs the restarted shell to continue, ask the user to reopen their terminal and rerun their original prompt.

## Agent Setup

Install Laravel Boost from the application root before making application changes:

```sh
composer require laravel/boost --dev
php artisan boost:install
```

Boost replaces these bootstrap instructions with guidelines tailored to the application. After installation, read `AGENTS.md` again and continue with the user's original request using the generated guidelines.
</laravel-boost-guidelines>

# Product Requirements Document
## Sistem Pengelolaan Event

---

## 1. Latar Belakang

Sebuah organisasi penyelenggara kegiatan di lingkungan sekolah secara rutin mengadakan berbagai event seperti seminar, workshop, lomba, pelatihan, dan kegiatan siswa. Proses pengelolaan event saat ini dilakukan menggunakan beberapa media yang berbeda, sehingga informasi event, peserta, jadwal, dan status pendaftaran sulit dipantau secara terpusat.

Client membutuhkan sistem berbasis web untuk mengelola event secara lebih terstruktur, terpusat, dan mudah dipantau oleh pengguna yang memiliki hak akses sesuai dengan tugasnya.

---

## 2. Permasalahan

| No | Permasalahan |
|----|--------------|
| 1 | Data event masih dicatat secara terpisah di berbagai media. |
| 2 | Pengelola kesulitan mengetahui status event (berlangsung / selesai). |
| 3 | Peserta harus melakukan proses pendaftaran secara manual. |
| 4 | Data peserta sulit dicari ketika jumlahnya sudah banyak. |
| 5 | Pengelola membutuhkan informasi peserta berdasarkan event tertentu. |
| 6 | Data pendaftaran harus dapat dikelola dan diperbarui. |
| 7 | Tidak semua pengguna boleh melakukan pengelolaan data. |
| 8 | Informasi event perlu ditampilkan dengan rapi kepada pengguna. |
| 9 | Sistem membutuhkan pembatasan akses berdasarkan jenis pengguna. |

---

## 3. Kebutuhan Sistem

### 3.1 Pengelolaan Event

Sistem menyediakan fitur CRUD lengkap untuk data event, mencakup:

- Membuat event baru
- Mengubah data event
- Menghapus event
- Melihat detail event
- Menentukan kategori event
- Menentukan jadwal event
- Menentukan kapasitas peserta
- Menentukan status event

### 3.2 Pendaftaran Event

Pengguna yang telah login dapat berinteraksi dengan event sebagai berikut:

- Melihat daftar event yang tersedia
- Melihat detail event
- Melakukan pendaftaran event
- Melihat riwayat dan status pendaftaran pribadi
- Sistem memvalidasi proses pendaftaran agar data yang masuk sesuai ketentuan

### 3.3 Pengelolaan Peserta

Pengelola dapat:

- Melihat data peserta berdasarkan event tertentu
- Mencari peserta menggunakan fitur search
- Memfilter data peserta
- Melihat data peserta dengan pagination

### 3.4 Hak Akses

Sistem memiliki **3 role pengguna**. Setiap role memiliki tanggung jawab, halaman yang dapat diakses, dan tindakan yang boleh dilakukan yang berbeda. Perbedaan hak akses wajib diterapkan menggunakan:

- **Authentication** — verifikasi identitas pengguna
- **Authorization** — pembatasan aksi berdasarkan role
- **Custom Middleware** — perlindungan route per role

### 3.5 Relasi Data

- Satu event dapat memiliki banyak peserta.
- Satu peserta dapat mengikuti beberapa event.
- Relasi many-to-many antara Event dan Peserta diimplementasikan menggunakan tabel pivot pendaftaran.
- Entitas lain ditentukan berdasarkan hasil analisis kebutuhan.

---


## 4. Role Pengguna & Hak Akses

| Role | Deskripsi | Hak Akses / Tanggung Jawab |
|------|-----------|------------------------------|
| **Admin** | Role untuk admin website | Manajemen CRUD user (Pengelola/Peserta), akses penuh ke semua data event dan pendaftaran, CRUD kategori |
| **Pengelola** | Role untuk pengelola event | Melihat dan mengelola CRUD event serta kategori, mengelola data pendaftaran per event |
| **Peserta** | Role untuk peserta event | Melihat daftar event, melihat detail event, mendaftar event, melihat status pendaftaran pribadi |

Perbedaan hak akses diterapkan melalui **Authentication**, **Authorization**, dan **Custom Middleware**.

---

## 5. Kebutuhan Fungsional

| No | Kebutuhan Sistem |
|----|-------------------|
| 1 | Authentication (Register & Login) |
| 2 | CRUD Event (khusus Pengelola) |
| 3 | CRUD Kategori (khusus Pengelola dan Admin) |
| 4 | Landing Page — menampilkan event yang tersedia dengan search, filter, dan pagination |
| 5 | Form Pendaftaran Event (diakses oleh Peserta) |
| 6 | Authorization (user diharuskan login/register) & Custom Middleware |
| 7 | Search, Pagination, dan Filter pada tabel CRUD |
| 8 | Dashboard Admin — CRUD Kategori, CRUD User |
| 9 | Dashboard Pengelola — CRUD Event, CRUD Kategori, Profile |
| 10 | CRUD User (Pengelola, Peserta & Admin) — khusus Admin |
| 11 | Manajemen Pendaftaran pada Event — tampil dari halaman detail/CRUD Event |
| 12 | Dashboard Peserta — Profile, Riwayat, dan Status Pendaftaran Event |

---

## 6. Product Backlog

| No | User Story | Prioritas |
|----|------------|-----------|
| 1 | Sebagai Peserta, saya ingin register, sehingga dapat mendaftarkan akun untuk mengakses sistem | Tinggi |
| 2 | Sebagai Peserta, saya ingin login, sehingga dapat mengakses dengan akun yang sudah terdaftar | Tinggi |
| 3 | Sebagai Peserta, saya ingin melihat landing page, sehingga dapat melihat event-event yang tersedia | Tinggi |
| 4 | Sebagai Peserta, saya ingin mengisi form pendaftaran event, sehingga dapat mendaftar event | Tinggi |
| 5 | Sebagai Peserta, saya ingin menggunakan search, filter, dan pagination pada landing page, sehingga mempermudah pencarian event | Sedang |
| 6 | Sebagai Peserta, saya ingin mengakses dashboard peserta, sehingga dapat mengubah profil serta melihat riwayat dan status pendaftaran | Tinggi |
| 7 | Sebagai Pengelola, saya ingin register, sehingga dapat mendaftarkan akun untuk mengakses sistem | Tinggi |
| 8 | Sebagai Pengelola, saya ingin login, sehingga dapat mengakses dengan akun yang sudah terdaftar | Tinggi |
| 9 | Sebagai Pengelola, saya ingin mengakses dashboard pengelola, sehingga dapat melihat tampilan visual data | Tinggi |
| 10 | Sebagai Pengelola, saya ingin mengakses landing page, sehingga dapat melihat event yang ada | Sedang |
| 11 | Sebagai Pengelola, saya ingin mengakses tabel CRUD Event pada dashboard, sehingga dapat mengelola event | Tinggi |
| 12 | Sebagai Pengelola, saya ingin mengakses tabel CRUD Kategori, sehingga dapat mengelola kategori event | Tinggi |
| 13 | Sebagai Pengelola, saya ingin mengakses halaman profile, sehingga dapat mengubah informasi profil | Rendah |
| 14 | Sebagai Admin, saya ingin register, sehingga dapat mendaftarkan akun untuk mengakses sistem | Tinggi |
| 15 | Sebagai Admin, saya ingin login, sehingga dapat mengakses dengan akun yang sudah terdaftar | Tinggi |
| 16 | Sebagai Admin, saya ingin melihat landing page, sehingga dapat melihat event-event yang tersedia | Tinggi |
| 17 | Sebagai Admin, saya ingin mengakses dashboard admin, sehingga dapat melihat visualisasi data yang dikelola | Tinggi |
| 18 | Sebagai Admin, saya ingin mengakses tabel CRUD Kategori, sehingga dapat mengelola kategori event | Tinggi |
| 19 | Sebagai Admin, saya ingin mengakses tabel CRUD User, sehingga dapat mengelola data user Peserta, Pengelola, dan Admin | Tinggi |
| 20 | Sebagai Admin, saya ingin menggunakan search, filter, dan pagination pada tabel CRUD, sehingga mempermudah pencarian data dan tidak membebani server | Tinggi |

---

## 7. Sprint Backlog (Sprint 1 — MVP)

| No | Task | Prioritas |
|----|------|-----------|
| 1 | Register & Login Page | Tinggi |
| 2 | Landing Page | Tinggi |
| 3 | Form Pendaftaran | Tinggi |
| 4 | Authorization + Custom Middleware | Tinggi |
| 5 | Dashboard Peserta | Tinggi |
| 6 | Profile Peserta Page | Tinggi |
| 7 | Riwayat & Status Pendaftaran Event Page | Tinggi |
| 8 | Dashboard Pengelola | Tinggi |
| 9 | CRUD Kategori Page (Pengelola) | Tinggi |
| 10 | CRUD Event Page (Pengelola) | Tinggi |
| 11 | Dashboard Admin | Tinggi |
| 12 | CRUD Kategori Page (Admin) | Tinggi |
| 13 | CRUD User Page (Admin) | Tinggi |
| 14 | Search, Filter, dan Pagination pada Tabel CRUD & Landing Page | Tinggi |

**Definisi selesai (Sprint 1):** seluruh role dapat register/login, Peserta dapat melihat dan mendaftar event, Pengelola dapat mengelola event dan kategori, Admin dapat mengelola user dan kategori, serta search/filter/pagination berfungsi di halaman utama.

---

## 8. Database Architecture

### Tabel `users`
| Kolom | Tipe |
|-------|------|
| id | bigint, PK |
| name | varchar |
| email | varchar, unique |
| password | varchar |
| phone | varchar, nullable |
| address | varchar, nullable |
| photo | varchar, nullable |
| role | enum('admin','pengelola','peserta') |
| created_at, updated_at | timestamp |

### Tabel `categories`
| Kolom | Tipe |
|-------|------|
| id | bigint, PK |
| name | varchar |
| created_at, updated_at | timestamp |

### Tabel `events`
| Kolom | Tipe |
|-------|------|
| id | bigint, PK |
| category_id | bigint, FK → categories.id |
| pengelola_id | bigint, FK → users.id |
| title | varchar |
| description | text |
| location | varchar |
| start_date | datetime |
| end_date | datetime, nullable |
| capacity | unsignedInteger |
| status | enum('upcoming','ongoing','completed','canceled') |
| created_at, updated_at | timestamp |

### Tabel `registrations`
| Kolom | Tipe |
|-------|------|
| id | bigint, PK |
| user_id | bigint, FK → users.id |
| event_id | bigint, FK → events.id |
| status | enum('pending','approved','rejected','canceled') |
| registered_at | timestamp |
| created_at, updated_at | timestamp |

### Relasi
- `users` (role pengelola) 1 — N `events`
- `categories` 1 — N `events`
- `users` (role peserta) N — N `events` melalui tabel pivot `registrations`
- Constraint unique pada `(user_id, event_id)` di tabel `registrations` untuk mencegah pendaftaran ganda pada event yang sama

## 9. Kompetensi Teknis yang Diterapkan
 
| No | Kompetensi |
|----|------------|
| 1 | MVC (Model-View-Controller) |
| 2 | Blade Templating |
| 3 | Authentication & Authorization |
| 4 | Eloquent ORM & Relasi Database |
| 5 | ERD |
| 6 | Custom Middleware |
| 7 | Validation & FormRequest |
| 8 | Search, Filter & Pagination |
| 9 | N+1 Query / Eager Loading |