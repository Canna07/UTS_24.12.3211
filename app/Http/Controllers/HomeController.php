<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
          $events = Event::with('category')->latest()->get();
        $partners = Partner::all();

        return view('welcome', compact('events', 'partners'));
    }
}