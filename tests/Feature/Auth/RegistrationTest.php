<?php

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
