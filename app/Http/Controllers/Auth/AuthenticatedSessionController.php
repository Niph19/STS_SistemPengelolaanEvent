<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        return match (Auth::user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
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

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
