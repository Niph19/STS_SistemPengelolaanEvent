<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    /**
     * Show all registrations for the logged-in peserta.
     */
    public function index(Request $request): View
    {
        $registrations = Registration::where('user_id', auth()->id())
            ->with(['event.category'])
            ->when($request->search, function ($q, $s) {
                $q->whereHas('event', fn ($eq) => $eq->where('title', 'like', "%{$s}%"));
            })
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->latest('registered_at')
            ->paginate(15)
            ->withQueryString();

        return view('peserta.registrations.index', compact('registrations'));
    }

    /**
     * Register the logged-in peserta to an event.
     */
    public function store(Request $request, Event $event)
    {
        // Event must be upcoming
        if ($event->status !== 'upcoming') {
            return back()->with('error', 'Event ini tidak menerima pendaftaran saat ini.');
        }

        // Check capacity
        $filledSlots = $event->registrations()
            ->whereIn('status', ['pending', 'approved'])
            ->count();

        if ($filledSlots >= $event->capacity) {
            return back()->with('error', 'Kuota event ini sudah penuh.');
        }

        // Check if already registered
        $alreadyRegistered = $event->registrations()
            ->where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($alreadyRegistered) {
            return back()->with('error', 'Kamu sudah terdaftar di event ini.');
        }

        Registration::create([
            'user_id'       => auth()->id(),
            'event_id'      => $event->id,
            'status'        => 'pending',
            'registered_at' => now(),
        ]);

        return redirect()->route('events.show', $event)
                         ->with('success', 'Pendaftaran berhasil! Menunggu persetujuan pengelola.');
    }

    /**
     * Cancel a pending registration.
     */
    public function destroy(Registration $registration)
    {
        abort_if($registration->user_id !== auth()->id(), 403);

        if ($registration->status !== 'pending') {
            return back()->with('error', 'Pendaftaran ini tidak dapat dibatalkan.');
        }

        $registration->update(['status' => 'canceled']);

        return back()->with('success', 'Pendaftaran berhasil dibatalkan.');
    }
}
