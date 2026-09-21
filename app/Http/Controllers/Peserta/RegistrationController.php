<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function index(Request $request): View
    {
        return view('peserta.registrations.index');
    }

    public function store(Request $request, Event $event)
    {
        //
    }

    public function destroy(Registration $registration)
    {
        //
    }
}
