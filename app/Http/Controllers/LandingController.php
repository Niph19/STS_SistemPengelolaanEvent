<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
    /**
     * Display the landing page with event list and filters.
     */
    public function index(Request $request): View
    {
        $categories = Category::orderBy('name')->get();

        $activeEvents = Event::whereIn('status', ['upcoming', 'ongoing'])->count();
        $registeredParticipants = Registration::whereIn('status', ['pending', 'approved'])
            ->distinct('user_id')
            ->count('user_id');

        $events = Event::with(['category', 'pengelola'])
            ->withCount(['registrations as registrations_count' => fn ($query) => $query->whereIn('status', ['pending', 'approved'])])
            ->filter($request->only(['search', 'category_id', 'status']))
            ->registrationOpen()
            ->orderBy('start_date')
            ->paginate(8)
            ->withQueryString();

        return view('landing', compact('events', 'categories', 'activeEvents', 'registeredParticipants'));
    }

    /**
     * Display the detail page for a specific event.
     */
    public function show(Event $event): View
    {
        $event->loadCount(['registrations as registrations_count' => fn ($query) => $query->whereIn('status', ['pending', 'approved'])]);
        $event->load(['category', 'pengelola']);

        // Check if the logged-in peserta has already registered
        $registered = false;
        if (auth()->check() && auth()->user()->role === 'peserta') {
            $registered = $event->registrations()
                ->where('user_id', auth()->id())
                ->whereIn('status', ['pending', 'approved'])
                ->exists();
        }

        return view('events.show', compact('event', 'registered'));
    }
}
