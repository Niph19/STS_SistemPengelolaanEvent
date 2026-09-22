<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalUsers      = User::count();
        $totalPengelola  = User::where('role', 'pengelola')->count();
        $totalPeserta    = User::where('role', 'peserta')->count();
        $totalCategories = Category::count();
        $totalEvents     = Event::count();
        $totalRegistrations = Registration::count();

        $recentUsers = User::latest()->limit(5)->get();
        $recentEvents = Event::with('category')->latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPengelola',
            'totalPeserta',
            'totalCategories',
            'totalEvents',
            'totalRegistrations',
            'recentUsers',
            'recentEvents'
        ));
    }
}
