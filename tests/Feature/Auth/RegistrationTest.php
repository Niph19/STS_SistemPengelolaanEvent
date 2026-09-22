<?php

use App\Models\Category;
use App\Models\Event;
use App\Models\User;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('landing', absolute: false));
});

test('pengelola is redirected to the pengelola dashboard after registration', function () {
    $response = $this->post('/register', [
        'name' => 'Test Pengelola',
        'email' => 'pengelola@example.com',
        'role' => 'pengelola',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('pengelola.dashboard', absolute: false));
});

test('peserta returns to the event after registration from event registration', function () {
    $event = Event::create([
        'category_id' => Category::create(['name' => 'Workshop'])->id,
        'pengelola_id' => User::factory()->create(['role' => 'pengelola'])->id,
        'title' => 'Event Register Test',
        'description' => 'Deskripsi event.',
        'location' => 'Lab Komputer',
        'start_date' => now()->addWeek(),
        'end_date' => now()->addWeek()->addHours(2),
        'capacity' => 50,
        'status' => 'upcoming',
    ]);

    $response = $this->post('/register', [
        'name' => 'Test Peserta Event',
        'email' => 'peserta-event@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'redirect' => route('events.show', $event),
    ]);

    $response->assertRedirect(route('events.show', $event, absolute: false));
});
