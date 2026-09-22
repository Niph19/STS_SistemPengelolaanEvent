# Panduan Pengembangan Backend — STS Sistem Pengelolaan Event

> Dokumen ini memandu pengembangan backend secara bertahap dari awal hingga selesai. Frontend (semua halaman Blade) sudah selesai dibuat. Backend yang perlu kamu bangun mencakup: logika controller, validasi FormRequest, middleware, seeder, dan fitur search/filter/pagination.

---

## Daftar Isi

1. [Status Saat Ini](#1-status-saat-ini)
2. [Setup Awal](#2-setup-awal)
3. [Database & Seeder](#3-database--seeder)
4. [Authentication — Perbaikan Register](#4-authentication--perbaikan-register)
5. [Middleware Role — Sudah Ada](#5-middleware-role--sudah-ada)
6. [ProfileController — Perbaikan](#6-profilecontroller--perbaikan)
7. [LandingController](#7-landingcontroller)
8. [Admin: DashboardController](#8-admin-dashboardcontroller)
9. [Admin: UserController](#9-admin-usercontroller)
10. [Admin: CategoryController](#10-admin-categorycontroller)
11. [Pengelola: DashboardController](#11-pengelola-dashboardcontroller)
12. [Pengelola: EventController](#12-pengelola-eventcontroller)
13. [Pengelola: CategoryController](#13-pengelola-categorycontroller)
14. [Pengelola: RegistrationController](#14-pengelola-registrationcontroller)
15. [Peserta: DashboardController](#15-peserta-dashboardcontroller)
16. [Peserta: RegistrationController](#16-peserta-registrationcontroller)
17. [Urutan Pengerjaan yang Disarankan](#17-urutan-pengerjaan-yang-disarankan)

---

## 1. Status Saat Ini

### ✅ Sudah Ada & Selesai
- Semua migrasi database (`users`, `categories`, `events`, `registrations`)
- Semua model dengan relasi (`User`, `Event`, `Category`, `Registration`)
- `Event::scopeFilter()` untuk search/filter
- `RoleMiddleware` + registrasi alias `role` di `bootstrap/app.php`
- Semua routes di `routes/web.php` dan `routes/auth.php`
- Semua views/halaman frontend (Blade)
- `ProfileController` (edit, update, destroy) — **sudah fungsional**
- `AuthenticatedSessionController` (login/logout) — **sudah fungsional**

### ❌ Belum Diimplementasikan (hanya stub/return view)
- `RegisteredUserController::store()` — belum menyimpan role dari form
- `LandingController::index()` dan `show()` — belum query database
- Semua Dashboard controllers — belum ada data statistik
- Semua CRUD controllers — method `store`, `update`, `destroy` masih kosong
- `RegistrationController` (Pengelola & Peserta) — masih stub

---

## 2. Setup Awal

Jalankan migrasi dan seeder sebelum mulai:

```bash
php artisan migrate:fresh --seed
```

Pastikan `.env` sudah dikonfigurasi (database SQLite sudah terkonfigurasi di project ini).

---

## 3. Database & Seeder

File `DatabaseSeeder.php` sudah ada. Isi dengan data dummy yang cukup untuk testing:

```php
// database/seeders/DatabaseSeeder.php
use App\Models\User;
use App\Models\Category;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Support\Facades\Hash;

public function run(): void
{
    // Admin
    User::create([
        'name'     => 'Admin Sistem',
        'email'    => 'admin@sts.id',
        'password' => Hash::make('password'),
        'role'     => 'admin',
    ]);

    // Pengelola
    $pengelola = User::create([
        'name'     => 'Budi Pengelola',
        'email'    => 'pengelola@sts.id',
        'password' => Hash::make('password'),
        'role'     => 'pengelola',
    ]);

    // Peserta
    $peserta = User::create([
        'name'     => 'Citra Peserta',
        'email'    => 'peserta@sts.id',
        'password' => Hash::make('password'),
        'role'     => 'peserta',
    ]);

    // Kategori
    $categories = Category::insert([
        ['name' => 'Seminar',  'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Workshop', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Lomba',    'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Pelatihan','created_at' => now(), 'updated_at' => now()],
    ]);

    // Event
    $cat = Category::first();
    $event = Event::create([
        'category_id'  => $cat->id,
        'pengelola_id' => $pengelola->id,
        'title'        => 'Seminar Teknologi 2026',
        'description'  => 'Seminar tentang perkembangan teknologi masa depan.',
        'location'     => 'Aula Utama SMAN 1',
        'start_date'   => now()->addDays(7),
        'end_date'     => now()->addDays(7)->addHours(4),
        'capacity'     => 100,
        'status'       => 'upcoming',
    ]);

    // Registrasi
    Registration::create([
        'user_id'       => $peserta->id,
        'event_id'      => $event->id,
        'status'        => 'pending',
        'registered_at' => now(),
    ]);
}
```

**Catatan penting:** Kolom `end_date` di migrasi saat ini `NOT NULL`. Jika kamu ingin membuatnya nullable (sesuai PRD), ubah migrasinya:
```php
$table->datetime('end_date')->nullable();
```
Lalu jalankan `php artisan migrate:fresh --seed` kembali.

---

## 4. Authentication — Perbaikan Register

File: `app/Http/Controllers/Auth/RegisteredUserController.php`

Method `store()` saat ini hardcode role ke `'peserta'`. Perbaiki agar membaca role dari form (yang sudah ada field-nya di view register):

```php
public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name'     => ['required', 'string', 'max:255'],
        'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        'role'     => ['required', 'in:peserta,pengelola'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role'     => $request->role,
    ]);

    event(new Registered($user));
    Auth::login($user);

    // Redirect ke dashboard sesuai role
    return match($user->role) {
        'pengelola' => redirect()->route('pengelola.dashboard'),
        default     => redirect()->route('peserta.dashboard'),
    };
}
```

**Catatan:** Role `admin` tidak bisa dibuat via register publik — hanya via seeder atau admin panel.

---

## 5. Middleware Role — Sudah Ada

`RoleMiddleware` sudah selesai dan terdaftar sebagai alias `role` di `bootstrap/app.php`. Tidak ada yang perlu dikerjakan di sini.

Routes sudah menggunakan middleware ini:
```php
Route::middleware(['auth', 'role:peserta'])->...
Route::middleware(['auth', 'role:pengelola'])->...
Route::middleware(['auth', 'role:admin'])->...
```

---

## 6. ProfileController — Perbaikan

File: `app/Http/Controllers/ProfileController.php`

Controller sudah ada dan fungsional. Yang perlu ditambahkan adalah field `phone` dan `address` di `ProfileUpdateRequest`.

File: `app/Http/Requests/ProfileUpdateRequest.php`

```php
public function rules(): array
{
    return [
        'name'    => ['required', 'string', 'max:255'],
        'email'   => ['required', 'string', 'lowercase', 'email', 'max:255',
                      Rule::unique(User::class)->ignore($this->user()->id)],
        'phone'   => ['nullable', 'string', 'max:20'],
        'address' => ['nullable', 'string', 'max:500'],
    ];
}
```

Pastikan method `update()` di `ProfileController` juga menyimpan field tersebut. Karena model `User` sudah memiliki `phone` dan `address` di `$fillable`, method `fill($request->validated())` otomatis akan menyimpannya.

---

## 7. LandingController

File: `app/Http/Controllers/LandingController.php`

Bersihkan method yang tidak perlu, implementasikan `index()` dan `show()`:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::orderBy('name')->get();

        $events = Event::with(['category', 'pengelola'])
            ->withCount('registrations')
            ->filter($request->only(['search', 'category_id', 'status']))
            ->orderBy('start_date')
            ->paginate(12)
            ->withQueryString();

        return view('landing', compact('events', 'categories'));
    }

    public function show(Event $event): View
    {
        $event->loadCount('registrations');
        $event->load(['category', 'pengelola']);

        // Apakah peserta yang login sudah terdaftar?
        $registered = false;
        if (auth()->check() && auth()->user()->role === 'peserta') {
            $registered = $event->registrations()
                ->where('user_id', auth()->id())
                ->whereIn('status', ['pending', 'approved'])
                ->exists();
        }

        return view('events.show', compact('event', 'registered'));
    }
}
```

**Penjelasan penting:**
- `withCount('registrations')` menghasilkan `$event->registrations_count` — dipakai di view untuk menampilkan peserta terdaftar.
- `withQueryString()` pada paginator mempertahankan query string (`?search=...&category_id=...`) saat berpindah halaman.
- `scopeFilter()` sudah ada di model Event — tinggal panggil `.filter($request->only([...]))`.

---

## 8. Admin: DashboardController

File: `app/Http/Controllers/Admin/DashboardController.php`

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalUsers      = User::count();
        $totalPengelola  = User::where('role', 'pengelola')->count();
        $totalPeserta    = User::where('role', 'peserta')->count();
        $totalCategories = Category::count();
        $recentUsers     = User::latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalPengelola', 'totalPeserta',
            'totalCategories', 'recentUsers'
        ));
    }
}
```

---

## 9. Admin: UserController

File: `app/Http/Controllers/Admin/UserController.php`

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::when($request->search, fn($q, $s) =>
                        $q->where('name', 'like', "%$s%")
                          ->orWhere('email', 'like', "%$s%"))
                    ->when($request->role, fn($q, $r) => $q->where('role', $r))
                    ->latest()
                    ->paginate(15)
                    ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users'],
            'role'     => ['required', 'in:admin,pengelola,peserta'],
            'password' => ['required', 'confirmed', 'min:8'],
            'phone'    => ['nullable', 'string', 'max:20'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user): View
    {
        $user->loadCount(['registrations', 'events']);
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role'     => ['required', 'in:admin,pengelola,peserta'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Cegah admin menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil dihapus.');
    }
}
```

---

## 10. Admin: CategoryController

File: `app/Http/Controllers/Admin/CategoryController.php`

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::withCount('events')
            ->when($request->search, fn($q, $s) => $q->where('name', 'like', "%$s%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categories,name'],
        ]);

        Category::create(['name' => $request->name]);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category): View
    {
        $category->loadCount('events');
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100',
                       Rule::unique('categories', 'name')->ignore($category->id)],
        ]);

        $category->update(['name' => $request->name]);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')
                         ->with('success', 'Kategori berhasil dihapus.');
    }
}
```

---

## 11. Pengelola: DashboardController

File: `app/Http/Controllers/Pengelola/DashboardController.php`

```php
<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $pengelolaId = auth()->id();

        $totalEvents       = Event::where('pengelola_id', $pengelolaId)->count();
        $upcomingEvents    = Event::where('pengelola_id', $pengelolaId)->where('status', 'upcoming')->count();
        $ongoingEvents     = Event::where('pengelola_id', $pengelolaId)->where('status', 'ongoing')->count();
        $totalParticipants = Event::where('pengelola_id', $pengelolaId)
                                  ->withCount('registrations')
                                  ->get()
                                  ->sum('registrations_count');

        $recentEvents = Event::where('pengelola_id', $pengelolaId)
                             ->withCount('registrations')
                             ->with('category')
                             ->latest()
                             ->limit(5)
                             ->get();

        return view('pengelola.dashboard', compact(
            'totalEvents', 'upcomingEvents', 'ongoingEvents',
            'totalParticipants', 'recentEvents'
        ));
    }
}
```

---

## 12. Pengelola: EventController

File: `app/Http/Controllers/Pengelola/EventController.php`

```php
<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::orderBy('name')->get();

        $events = Event::where('pengelola_id', auth()->id())
            ->with('category')
            ->withCount('registrations')
            ->filter($request->only(['search', 'category_id', 'status']))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('pengelola.events.index', compact('events', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('pengelola.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location'    => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'start_date'  => ['required', 'date', 'after:now'],
            'end_date'    => ['nullable', 'date', 'after:start_date'],
            'capacity'    => ['required', 'integer', 'min:1'],
            'status'      => ['required', 'in:upcoming,ongoing,completed,canceled'],
        ]);

        $validated['pengelola_id'] = auth()->id();
        Event::create($validated);

        return redirect()->route('pengelola.events.index')
                         ->with('success', 'Event berhasil dibuat.');
    }

    public function show(Event $event): View
    {
        // Otorisasi: pastikan hanya pengelola pemilik yang bisa lihat
        abort_if($event->pengelola_id !== auth()->id(), 403);

        $event->loadCount('registrations');
        $event->load('category');

        return view('pengelola.events.show', compact('event'));
    }

    public function edit(Event $event): View
    {
        abort_if($event->pengelola_id !== auth()->id(), 403);

        $categories = Category::orderBy('name')->get();
        return view('pengelola.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        abort_if($event->pengelola_id !== auth()->id(), 403);

        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location'    => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'start_date'  => ['required', 'date'],
            'end_date'    => ['nullable', 'date', 'after:start_date'],
            'capacity'    => ['required', 'integer', 'min:1'],
            'status'      => ['required', 'in:upcoming,ongoing,completed,canceled'],
        ]);

        $event->update($validated);

        return redirect()->route('pengelola.events.show', $event)
                         ->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        abort_if($event->pengelola_id !== auth()->id(), 403);

        $event->delete();

        return redirect()->route('pengelola.events.index')
                         ->with('success', 'Event berhasil dihapus.');
    }
}
```

---

## 13. Pengelola: CategoryController

File: `app/Http/Controllers/Pengelola/CategoryController.php`

```php
<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::withCount('events')
            ->when($request->search, fn($q, $s) => $q->where('name', 'like', "%$s%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('pengelola.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('pengelola.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categories,name'],
        ]);

        Category::create(['name' => $request->name]);

        return redirect()->route('pengelola.categories.index')
                         ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category): View
    {
        $category->loadCount('events');
        return view('pengelola.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100',
                       Rule::unique('categories', 'name')->ignore($category->id)],
        ]);

        $category->update(['name' => $request->name]);

        return redirect()->route('pengelola.categories.index')
                         ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('pengelola.categories.index')
                         ->with('success', 'Kategori berhasil dihapus.');
    }
}
```

---

## 14. Pengelola: RegistrationController

File: `app/Http/Controllers/Pengelola/RegistrationController.php`

```php
<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function index(Event $event, Request $request): View
    {
        // Pastikan event milik pengelola ini
        abort_if($event->pengelola_id !== auth()->id(), 403);

        $event->loadCount('registrations');

        $registrations = $event->registrations()
            ->with('user')
            ->when($request->search, function ($q, $s) {
                $q->whereHas('user', fn($uq) =>
                    $uq->where('name', 'like', "%$s%")
                       ->orWhere('email', 'like', "%$s%")
                );
            })
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->latest('registered_at')
            ->paginate(20)
            ->withQueryString();

        return view('pengelola.registrations.index', compact('event', 'registrations'));
    }

    public function updateStatus(Request $request, Registration $registration)
    {
        // Pastikan registration ini milik event yang dikelola pengelola ini
        abort_if($registration->event->pengelola_id !== auth()->id(), 403);

        $request->validate([
            'status' => ['required', 'in:approved,rejected,pending,canceled'],
        ]);

        $registration->update(['status' => $request->status]);

        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }
}
```

---

## 15. Peserta: DashboardController

File: `app/Http/Controllers/Peserta/DashboardController.php`

```php
<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();

        $totalRegistrations = Registration::where('user_id', $userId)->count();
        $pendingCount       = Registration::where('user_id', $userId)->where('status', 'pending')->count();
        $approvedCount      = Registration::where('user_id', $userId)->where('status', 'approved')->count();
        $rejectedCount      = Registration::where('user_id', $userId)->where('status', 'rejected')->count();

        $recentRegistrations = Registration::where('user_id', $userId)
            ->with(['event.category'])
            ->latest('registered_at')
            ->limit(5)
            ->get();

        return view('peserta.dashboard', compact(
            'totalRegistrations', 'pendingCount', 'approvedCount',
            'rejectedCount', 'recentRegistrations'
        ));
    }
}
```

---

## 16. Peserta: RegistrationController

File: `app/Http/Controllers/Peserta/RegistrationController.php`

```php
<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function index(Request $request): View
    {
        $registrations = Registration::where('user_id', auth()->id())
            ->with(['event.category'])
            ->when($request->search, function ($q, $s) {
                $q->whereHas('event', fn($eq) => $eq->where('title', 'like', "%$s%"));
            })
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->latest('registered_at')
            ->paginate(15)
            ->withQueryString();

        return view('peserta.registrations.index', compact('registrations'));
    }

    public function store(Request $request, Event $event)
    {
        // Validasi: event harus upcoming
        if ($event->status !== 'upcoming') {
            return back()->with('error', 'Event ini tidak menerima pendaftaran saat ini.');
        }

        // Validasi: kuota tidak penuh
        $filledSlots = $event->registrations()->whereIn('status', ['pending', 'approved'])->count();
        if ($filledSlots >= $event->capacity) {
            return back()->with('error', 'Kuota event ini sudah penuh.');
        }

        // Validasi: belum terdaftar
        $alreadyRegistered = $event->registrations()
            ->where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($alreadyRegistered) {
            return back()->with('error', 'Kamu sudah terdaftar di event ini.');
        }

        Registration::create([
            'user_id'       => auth()->id(),
            'event_id'      => $event->id,
            'status'        => 'pending',
            'registered_at' => now(),
        ]);

        return redirect()->route('events.show', $event)
                         ->with('success', 'Pendaftaran berhasil! Menunggu persetujuan pengelola.');
    }

    public function destroy(Registration $registration)
    {
        // Pastikan hanya pemilik yang bisa membatalkan
        abort_if($registration->user_id !== auth()->id(), 403);

        // Hanya bisa batalkan jika masih pending
        if ($registration->status !== 'pending') {
            return back()->with('error', 'Pendaftaran ini tidak dapat dibatalkan.');
        }

        $registration->update(['status' => 'canceled']);

        return back()->with('success', 'Pendaftaran berhasil dibatalkan.');
    }
}
```

---

## 17. Urutan Pengerjaan yang Disarankan

Ikuti urutan ini agar aplikasi bisa diuji lebih awal:

| Urutan | File | Keterangan |
|--------|------|------------|
| 1 | `DatabaseSeeder.php` | Buat data dummy, jalankan `migrate:fresh --seed` |
| 2 | `Auth/RegisteredUserController::store()` | Tambah validasi role |
| 3 | `LandingController` | Index & show dengan query database |
| 4 | `Admin/DashboardController` | Data statistik |
| 5 | `Admin/CategoryController` | CRUD lengkap |
| 6 | `Admin/UserController` | CRUD lengkap |
| 7 | `Pengelola/DashboardController` | Data statistik |
| 8 | `Pengelola/CategoryController` | CRUD lengkap |
| 9 | `Pengelola/EventController` | CRUD lengkap |
| 10 | `Pengelola/RegistrationController` | index + updateStatus |
| 11 | `Peserta/DashboardController` | Data statistik |
| 12 | `Peserta/RegistrationController` | index + store + destroy |
| 13 | `ProfileUpdateRequest` | Tambah field phone & address |

---

## Hal-Hal Penting Lainnya

### Eager Loading & N+1 Query
Selalu gunakan `with()` dan `withCount()` saat query relasi. Contoh:
```php
// ❌ N+1 query (hindari)
$events = Event::all();
foreach ($events as $e) { echo $e->category->name; }

// ✅ Eager loading
$events = Event::with('category')->withCount('registrations')->get();
```

### Unique Constraint di Registrations
Tabel `registrations` saat ini tidak memiliki unique constraint `(user_id, event_id)`. Logika pencegahan duplikasi sudah ditangani di controller (cek `alreadyRegistered`). Jika ingin tambahkan di database level, buat migrasi baru:
```php
$table->unique(['user_id', 'event_id']);
```

### Flash Messages
Semua view sudah menangani `session('success')` dan `session('error')` melalui layout dashboard. Pastikan setiap redirect menggunakan `->with('success', '...')` atau `->with('error', '...')`.

### Pagination Style
Agar pagination styling sesuai dengan dark theme, tambahkan di `AppServiceProvider::boot()`:
```php
use Illuminate\Pagination\Paginator;

Paginator::useBootstrapFive(); // atau
Paginator::defaultView('vendor.pagination.tailwind');
```
Atau publish dan customize view pagination:
```bash
php artisan vendor:publish --tag=laravel-pagination
```

### Redirect Setelah Login
Di `AuthenticatedSessionController`, redirect setelah login saat ini ke route `dashboard` atau yang dikonfigurasi. Sesuaikan agar redirect ke dashboard sesuai role:
```php
// Di method store() AuthenticatedSessionController
return redirect()->intended(match(auth()->user()->role) {
    'admin'     => route('admin.dashboard'),
    'pengelola' => route('pengelola.dashboard'),
    default     => route('peserta.dashboard'),
});
```
