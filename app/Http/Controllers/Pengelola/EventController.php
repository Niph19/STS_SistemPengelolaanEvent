<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        return view('pengelola.events.index');
    }

    public function create(): View
    {
        return view('pengelola.events.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Event $event): View
    {
        return view('pengelola.events.show', compact('event'));
    }

    public function edit(Event $event): View
    {
        return view('pengelola.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        //
    }

    public function destroy(Event $event)
    {
        //
    }
}
