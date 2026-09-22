<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $pengelolaId = auth()->id();

        $totalEvents    = Event::where('pengelola_id', $pengelolaId)->count();
        $upcomingEvents = Event::where('pengelola_id', $pengelolaId)->where('status', 'upcoming')->count();
        $ongoingEvents  = Event::where('pengelola_id', $pengelolaId)->where('status', 'ongoing')->count();
        $completedEvents = Event::where('pengelola_id', $pengelolaId)->where('status', 'completed')->count();

        $totalParticipants = Event::where('pengelola_id', $pengelolaId)
            ->withCount('registrations')
            ->get()
            ->sum('registrations_count');

        $recentEvents = Event::where('pengelola_id', $pengelolaId)
            ->withCount('registrations')
            ->with('category')
            ->latest()
            ->limit(5)
            ->get();

        return view('pengelola.dashboard', compact(
            'totalEvents',
            'upcomingEvents',
            'ongoingEvents',
            'completedEvents',
            'totalParticipants',
            'recentEvents'
        ));
    }
}
