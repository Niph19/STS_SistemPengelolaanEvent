<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('+3 days', '+90 days');

        return [
            'category_id' => fn () => Category::inRandomOrder()->value('id'),
            'pengelola_id' => fn () => User::where('role', 'pengelola')->inRandomOrder()->value('id'),
            'title' => fake()->randomElement([
                'Seminar Inovasi Pelajar',
                'Workshop Teknologi Kreatif',
                'Kompetisi Prestasi Siswa',
                'Pelatihan Keterampilan Digital',
                'Webinar Persiapan Karier',
            ]).' '.fake()->unique()->numberBetween(2026, 9999),
            'description' => fake()->paragraphs(2, true),
            'location' => fake()->randomElement([
                'Aula Utama Sekolah',
                'Lab Komputer',
                'Gedung Serbaguna',
                'Ruang Multimedia',
                'Online (Zoom)',
            ]),
            'start_date' => $startDate,
            'end_date' => (clone $startDate)->modify('+'.fake()->numberBetween(2, 6).' hours'),
            'capacity' => fake()->numberBetween(30, 300),
            'status' => 'upcoming',
        ];
    }

    public function forExistingRelations(Category $category, User $pengelola): static
    {
        return $this->state([
            'category_id' => $category->id,
            'pengelola_id' => $pengelola->id,
        ]);
    }
}