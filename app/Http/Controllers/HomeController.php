<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;

class HomeController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::where('status', 'available')->take(6)->get();
        return view('home', compact('vehicles'));
    }
}
