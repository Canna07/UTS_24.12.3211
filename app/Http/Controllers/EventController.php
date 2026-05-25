<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
     // Halaman detail event
    public function show()
    {
        return view('event-detail');
    }

    // Halaman checkout
    public function checkout()
    {
        return view('checkout');
    }
}
