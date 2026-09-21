<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function index(Event $event, Request $request): View
    {
        return view('pengelola.registrations.index', compact('event'));
    }

    public function updateStatus(Request $request, Registration $registration)
    {
        //
    }
}
