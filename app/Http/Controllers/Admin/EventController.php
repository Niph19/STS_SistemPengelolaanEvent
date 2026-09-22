<?php

namespace App\Http\Controllers\Admin;

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
        $events = Event::with(['category', 'pengelola'])
            ->withCount(['registrations as registrations_count' => fn ($query) => $query->whereIn('status', ['pending', 'approved'])])
            ->filter($request->only(['search', 'category_id', 'status']))
            ->latest('start_date')
            ->paginate(15)
            ->withQueryString();

        return view('admin.events.index', compact('events', 'categories'));
    }

    public function create(): View
    {
        return view('admin.events.create', [
            'categories' => Category::orderBy('name')->get(),
            'pengelolas' => \App\Models\User::where('role', 'pengelola')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $event = Event::create($this->validated($request) + ['pengelola_id' => $request->integer('pengelola_id')]);

        return redirect()->route('admin.events.show', $event)->with('success', 'Event berhasil dibuat.');
    }

    public function show(Event $event): View
    {
        $event->load(['category', 'pengelola'])->loadCount('registrations');

        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event): View
    {
        return view('admin.events.edit', [
            'event' => $event,
            'categories' => Category::orderBy('name')->get(),
            'pengelolas' => \App\Models\User::where('role', 'pengelola')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $event->update($this->validated($request) + ['pengelola_id' => $request->integer('pengelola_id')]);

        return redirect()->route('admin.events.show', $event)->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'pengelola_id' => ['required', 'exists:users,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'capacity' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:upcoming,ongoing,completed,canceled'],
        ]);
    }
}
