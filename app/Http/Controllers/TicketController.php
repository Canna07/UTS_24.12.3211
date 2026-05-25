<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
      // Halaman tiket
    public function index()
    {
        return view('ticket');
    }
}
