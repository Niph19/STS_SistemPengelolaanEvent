<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::orderBy('name')->get();

        $events = Event::where('pengelola_id', auth()->id())
            ->with('category')
            ->withCount('registrations')
            ->filter($request->only(['search', 'category_id', 'status']))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('pengelola.events.index', compact('events', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('pengelola.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location'    => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'start_date'  => ['required', 'date', 'after:now'],
            'end_date'    => ['nullable', 'date', 'after:start_date'],
            'capacity'    => ['required', 'integer', 'min:1'],
            'status'      => ['required', 'in:upcoming,ongoing,completed,canceled'],
        ]);

        $validated['pengelola_id'] = auth()->id();
        Event::create($validated);

        return redirect()->route('pengelola.events.index')
                         ->with('success', 'Event berhasil dibuat.');
    }

    public function show(Event $event): View
    {
        abort_if($event->pengelola_id !== auth()->id(), 403);

        $event->loadCount('registrations');
        $event->load('category');

        $recentRegistrations = $event->registrations()
            ->with('user')
            ->latest('registered_at')
            ->limit(5)
            ->get();

        return view('pengelola.events.show', compact('event', 'recentRegistrations'));
    }

    public function edit(Event $event): View
    {
        abort_if($event->pengelola_id !== auth()->id(), 403);

        $categories = Category::orderBy('name')->get();
        return view('pengelola.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        abort_if($event->pengelola_id !== auth()->id(), 403);

        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location'    => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'start_date'  => ['required', 'date'],
            'end_date'    => ['nullable', 'date', 'after:start_date'],
            'capacity'    => ['required', 'integer', 'min:1'],
            'status'      => ['required', 'in:upcoming,ongoing,completed,canceled'],
        ]);

        $event->update($validated);

        return redirect()->route('pengelola.events.show', $event)
                         ->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        abort_if($event->pengelola_id !== auth()->id(), 403);

        $event->delete();

        return redirect()->route('pengelola.events.index')
                         ->with('success', 'Event berhasil dihapus.');
    }
}
