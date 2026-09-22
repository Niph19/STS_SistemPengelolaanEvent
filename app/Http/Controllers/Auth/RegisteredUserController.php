<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(RegisterUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'] ?? 'peserta',
        ]);

        event(new Registered($user));
        Auth::login($user);

        return match ($user->role) {
            'pengelola' => redirect()->route('pengelola.dashboard'),
            default => redirect()->to($this->safeRedirect($request)),
        };
    }

    private function safeRedirect(Request $request): string
    {
        $redirect = $request->input('redirect');

        if (! is_string($redirect) || $redirect === '') {
            return route('landing');
        }

        $parsed = parse_url($redirect);

        if (isset($parsed['host']) && $parsed['host'] !== $request->getHost()) {
            return route('landing');
        }

        return $parsed['path'] ?? route('landing');
    }
}
