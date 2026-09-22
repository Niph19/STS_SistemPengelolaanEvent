<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    /**
     * List registrations for a specific event.
     */
    public function index(Event $event, Request $request): View
    {
        abort_if($event->pengelola_id !== auth()->id(), 403);

        $event->loadCount(['registrations as registrations_count' => fn ($query) => $query->whereIn('status', ['pending', 'approved'])]);

        $registrations = $event->registrations()
            ->with('user')
            ->when($request->search, function ($q, $s) {
                $q->whereHas('user', fn ($uq) =>
                    $uq->where('name', 'like', "%{$s}%")
                       ->orWhere('email', 'like', "%{$s}%")
                );
            })
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->latest('registered_at')
            ->paginate(20)
            ->withQueryString();

        return view('pengelola.registrations.index', compact('event', 'registrations'));
    }

    /**
     * Update the status of a registration.
     */
    public function updateStatus(Request $request, Registration $registration)
    {
        abort_if($registration->event->pengelola_id !== auth()->id(), 403);

        $request->validate([
            'status' => ['required', 'in:approved,rejected,pending,canceled'],
        ]);

        $registration->update(['status' => $request->status]);

        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }
}
