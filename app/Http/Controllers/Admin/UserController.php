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
                $users = User::when($request->search, fn ($q, $s) =>
                                                $q->where(function ($query) use ($s) {
                                                        $query->where('name', 'like', "%{$s}%")
                                                                ->orWhere('email', 'like', "%{$s}%");
                                                }))
                    ->when($request->role, fn ($q, $r) => $q->where('role', $r))
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
            'address'  => ['nullable', 'string', 'max:500'],
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
            'address'  => ['nullable', 'string', 'max:500'],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        if (! empty($validated['password'])) {
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
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil dihapus.');
    }
}
