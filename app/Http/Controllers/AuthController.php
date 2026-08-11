<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(): View
    {
        return view('login');
    }

    public function store(): RedirectResponse
    {
        return redirect()->route('dashboard');
    }
}
