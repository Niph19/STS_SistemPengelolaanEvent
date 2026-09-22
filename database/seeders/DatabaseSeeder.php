<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- Users ---
        User::create([
            'name'     => 'Admin Sistem',
            'email'    => 'admin@sts.id',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'phone'    => '081200000001',
            'address'  => 'Jl. Admin No. 1, Jakarta',
        ]);

        $pengelola1 = User::create([
            'name'     => 'Budi Pengelola',
            'email'    => 'pengelola@sts.id',
            'password' => Hash::make('password'),
            'role'     => 'pengelola',
            'phone'    => '081200000002',
            'address'  => 'Jl. Pengelola No. 2, Bandung',
        ]);

        $pengelola2 = User::create([
            'name'     => 'Dewi Pengelola',
            'email'    => 'pengelola2@sts.id',
            'password' => Hash::make('password'),
            'role'     => 'pengelola',
            'phone'    => '081200000003',
            'address'  => 'Jl. Mawar No. 5, Surabaya',
        ]);

        $peserta1 = User::create([
            'name'     => 'Citra Peserta',
            'email'    => 'peserta@sts.id',
            'password' => Hash::make('password'),
            'role'     => 'peserta',
            'phone'    => '081200000004',
            'address'  => 'Jl. Peserta No. 3, Yogyakarta',
        ]);

        $peserta2 = User::create([
            'name'     => 'Eko Santoso',
            'email'    => 'peserta2@sts.id',
            'password' => Hash::make('password'),
            'role'     => 'peserta',
            'phone'    => '081200000005',
            'address'  => 'Jl. Merdeka No. 10, Semarang',
        ]);

        $peserta3 = User::create([
            'name'     => 'Farida Hanum',
            'email'    => 'peserta3@sts.id',
            'password' => Hash::make('password'),
            'role'     => 'peserta',
            'phone'    => '081200000006',
            'address'  => 'Jl. Anggrek No. 7, Medan',
        ]);

        // --- Kategori ---
        $seminar   = Category::create(['name' => 'Seminar']);
        $workshop  = Category::create(['name' => 'Workshop']);
        $lomba     = Category::create(['name' => 'Lomba']);
        $pelatihan = Category::create(['name' => 'Pelatihan']);
        $webinar   = Category::create(['name' => 'Webinar']);

        // --- Events ---
        $event1 = Event::create([
            'category_id'  => $seminar->id,
            'pengelola_id' => $pengelola1->id,
            'title'        => 'Seminar Teknologi 2026',
            'description'  => 'Seminar tentang perkembangan teknologi masa depan: AI, IoT, dan Web3. Hadirkan para pakar terkemuka di bidangnya.',
            'location'     => 'Aula Utama SMAN 1',
            'start_date'   => now()->addDays(7),
            'end_date'     => now()->addDays(7)->addHours(4),
            'capacity'     => 100,
            'status'       => 'upcoming',
        ]);

        $event2 = Event::create([
            'category_id'  => $workshop->id,
            'pengelola_id' => $pengelola1->id,
            'title'        => 'Workshop Laravel untuk Pemula',
            'description'  => 'Workshop intensif belajar Laravel dari dasar hingga membuat aplikasi web sederhana. Cocok untuk siswa dan mahasiswa.',
            'location'     => 'Lab Komputer SMAN 1',
            'start_date'   => now()->addDays(14),
            'end_date'     => now()->addDays(15),
            'capacity'     => 30,
            'status'       => 'upcoming',
        ]);

        $event3 = Event::create([
            'category_id'  => $lomba->id,
            'pengelola_id' => $pengelola2->id,
            'title'        => 'Lomba Desain Poster Nasional',
            'description'  => 'Kompetisi desain poster tingkat nasional dengan tema "Indonesia Inovatif". Hadiah total Rp 10 juta.',
            'location'     => 'Online (Zoom)',
            'start_date'   => now()->addDays(21),
            'end_date'     => now()->addDays(22),
            'capacity'     => 200,
            'status'       => 'upcoming',
        ]);

        $event4 = Event::create([
            'category_id'  => $pelatihan->id,
            'pengelola_id' => $pengelola2->id,
            'title'        => 'Pelatihan Kepemimpinan Siswa',
            'description'  => 'Pelatihan intensif kepemimpinan untuk pengurus OSIS dan organisasi siswa. Membangun karakter pemimpin muda.',
            'location'     => 'Gedung Serbaguna SMAN 1',
            'start_date'   => now()->subDays(2),
            'end_date'     => now()->addDays(1),
            'capacity'     => 50,
            'status'       => 'ongoing',
        ]);

        $event5 = Event::create([
            'category_id'  => $webinar->id,
            'pengelola_id' => $pengelola1->id,
            'title'        => 'Webinar Karir di Bidang IT',
            'description'  => 'Webinar interaktif membahas prospek karir di dunia IT bersama praktisi industri dari Google, Tokopedia, dan Gojek.',
            'location'     => 'Online (Google Meet)',
            'start_date'   => now()->subDays(30),
            'end_date'     => now()->subDays(30)->addHours(3),
            'capacity'     => 500,
            'status'       => 'completed',
        ]);

        $event6 = Event::create([
            'category_id'  => $seminar->id,
            'pengelola_id' => $pengelola2->id,
            'title'        => 'Seminar Kesehatan Remaja',
            'description'  => 'Seminar tentang kesehatan fisik dan mental remaja bersama dokter spesialis. Gratis untuk seluruh siswa.',
            'location'     => 'Aula SMAN 2',
            'start_date'   => now()->addDays(3),
            'end_date'     => now()->addDays(3)->addHours(3),
            'capacity'     => 150,
            'status'       => 'upcoming',
        ]);

        // --- Tambahan 24 event dari factory sehingga total menjadi 30 event ---
        Event::factory()
            ->count(24)
            ->state(fn () => [
                'category_id' => Category::inRandomOrder()->value('id'),
                'pengelola_id' => User::where('role', 'pengelola')->inRandomOrder()->value('id'),
            ])
            ->create();

        // --- Registrasi ---
        Registration::create([
            'user_id'       => $peserta1->id,
            'event_id'      => $event1->id,
            'status'        => 'pending',
            'registered_at' => now()->subHours(2),
        ]);

        Registration::create([
            'user_id'       => $peserta1->id,
            'event_id'      => $event2->id,
            'status'        => 'approved',
            'registered_at' => now()->subDays(3),
        ]);

        Registration::create([
            'user_id'       => $peserta1->id,
            'event_id'      => $event5->id,
            'status'        => 'approved',
            'registered_at' => now()->subDays(35),
        ]);

        Registration::create([
            'user_id'       => $peserta2->id,
            'event_id'      => $event1->id,
            'status'        => 'approved',
            'registered_at' => now()->subDays(1),
        ]);

        Registration::create([
            'user_id'       => $peserta2->id,
            'event_id'      => $event3->id,
            'status'        => 'pending',
            'registered_at' => now()->subHours(5),
        ]);

        Registration::create([
            'user_id'       => $peserta3->id,
            'event_id'      => $event4->id,
            'status'        => 'approved',
            'registered_at' => now()->subDays(4),
        ]);

        Registration::create([
            'user_id'       => $peserta3->id,
            'event_id'      => $event1->id,
            'status'        => 'rejected',
            'registered_at' => now()->subDays(2),
        ]);
    }
}
