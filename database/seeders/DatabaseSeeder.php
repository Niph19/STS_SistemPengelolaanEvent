<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Peserta',
            'email' => 'peserta@example.com',
            'password' => 'asdasdasd',
            'phone' => '123123',
            'address' => 'jalan poras',
            'photo' => 'photo.png',
            'role' => 'peserta',
        ]);

        User::factory()->create([
            'name' => 'Pengelola',
            'email' => 'pengelola@example.com',
            'password' => 'asdasdasd',
            'phone' => '123123',
            'address' => 'jalan poras',
            'photo' => 'photo.png',
            'role' => 'pengelola',
        ]);
        
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'asdasdasd',
            'phone' => '123123',
            'address' => 'jalan poras',
            'photo' => 'photo.png',
            'role' => 'admin',
        ]);

        $categories = collect([
            'Seminar',
            'Workshop',
            'Lomba',
            'Pelatihan',
            'Kegiatan Siswa',
        ])->mapWithKeys(function (string $name) {
            $category = Category::create(['name' => $name]);

            return [$name => $category];
        });

        $pengelola = User::where('email', 'pengelola@example.com')->firstOrFail();

        Event::create([
            'category_id' => $categories['Seminar']->id,
            'pengelola_id' => $pengelola->id,
            'title' => 'Seminar Pengembangan Diri',
            'description' => 'Seminar tentang pengembangan potensi dan keterampilan siswa.',
            'location' => 'Aula Sekolah',
            'start_date' => now()->addDays(7)->setTime(9, 0),
            'end_date' => now()->addDays(7)->setTime(12, 0),
            'capacity' => 100,
            'status' => 'upcoming',
        ]);

        Event::create([
            'category_id' => $categories['Workshop']->id,
            'pengelola_id' => $pengelola->id,
            'title' => 'Workshop Desain Kreatif',
            'description' => 'Workshop praktik dasar desain kreatif untuk peserta.',
            'location' => 'Laboratorium Komputer',
            'start_date' => now()->addDays(14)->setTime(8, 0),
            'end_date' => now()->addDays(14)->setTime(15, 0),
            'capacity' => 40,
            'status' => 'upcoming',
        ]);

        Event::create([
            'category_id' => $categories['Lomba']->id,
            'pengelola_id' => $pengelola->id,
            'title' => 'Lomba Kreativitas Siswa',
            'description' => 'Kompetisi kreativitas antar siswa dalam berbagai bidang.',
            'location' => 'Lapangan Sekolah',
            'start_date' => now()->addDays(21)->setTime(8, 0),
            'end_date' => now()->addDays(21)->setTime(16, 0),
            'capacity' => 80,
            'status' => 'upcoming',
        ]);

        
    }
}
