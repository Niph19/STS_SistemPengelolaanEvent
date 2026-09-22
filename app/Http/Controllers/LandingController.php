<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
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

        $events = Event::with(['category', 'pengelola'])
            ->withCount('registrations')
            ->filter($request->only(['search', 'category_id', 'status']))
            ->orderBy('start_date')
            ->paginate(12)
            ->withQueryString();

        return view('landing', compact('events', 'categories'));
    }

    /**
     * Display the detail page for a specific event.
     */
    public function show(Event $event): View
    {
        $event->loadCount('registrations');
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
