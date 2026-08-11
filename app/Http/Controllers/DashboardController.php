<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\View;

#[Middleware('auth')]
class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard');
    }
}
