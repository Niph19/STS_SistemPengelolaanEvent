<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function index(Event $event, Request $request): View
    {
        $registrations = $event->registrations()
            ->with('user')
            ->when($request->search, fn ($query, $search) => $query->whereHas('user', fn ($user) => $user->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%")))
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->latest('registered_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.registrations.index', compact('event', 'registrations'));
    }

    public function updateStatus(Request $request, Registration $registration)
    {
        $registration->update($request->validate([
            'status' => ['required', 'in:pending,approved,rejected,canceled'],
        ]));

        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }
}
