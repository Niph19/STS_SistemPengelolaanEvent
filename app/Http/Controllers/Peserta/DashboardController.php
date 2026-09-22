<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();

        $totalRegistrations = Registration::where('user_id', $userId)->count();
        $pendingCount       = Registration::where('user_id', $userId)->where('status', 'pending')->count();
        $approvedCount      = Registration::where('user_id', $userId)->where('status', 'approved')->count();
        $rejectedCount      = Registration::where('user_id', $userId)->where('status', 'rejected')->count();

        $recentRegistrations = Registration::where('user_id', $userId)
            ->with(['event.category'])
            ->latest('registered_at')
            ->limit(5)
            ->get();

        return view('peserta.dashboard', compact(
            'totalRegistrations',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'recentRegistrations'
        ));
    }
}
