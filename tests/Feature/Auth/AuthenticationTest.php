<?php

use App\Models\User;
use App\Models\Category;
use App\Models\Event;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('landing', absolute: false));
});

test('admin is redirected to the admin dashboard after login', function () {
    $user = User::factory()->create(['role' => 'admin']);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect(route('admin.dashboard', absolute: false));
});

test('peserta returns to the event after login from event registration', function () {
    $event = Event::create([
        'category_id' => Category::create(['name' => 'Seminar'])->id,
        'pengelola_id' => User::factory()->create(['role' => 'pengelola'])->id,
        'title' => 'Event Login Test',
        'description' => 'Deskripsi event.',
        'location' => 'Aula Sekolah',
        'start_date' => now()->addWeek(),
        'end_date' => now()->addWeek()->addHours(2),
        'capacity' => 50,
        'status' => 'upcoming',
    ]);
    $user = User::factory()->create(['role' => 'peserta']);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
        'redirect' => route('events.show', $event),
    ]);

    $response->assertRedirect(route('events.show', $event, absolute: false));
});

test('pengelola is redirected to the pengelola dashboard after login', function () {
    $user = User::factory()->create(['role' => 'pengelola']);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect(route('pengelola.dashboard', absolute: false));
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});
