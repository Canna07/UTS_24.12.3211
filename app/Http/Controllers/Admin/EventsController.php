<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventsController extends Controller
{
      public function index()
    {
    $events = \App\Models\Event::all();
    return view('admin.events.index', compact('events'));
    }
    
    public function create()
{
    return view('admin.events.create');
}
}
