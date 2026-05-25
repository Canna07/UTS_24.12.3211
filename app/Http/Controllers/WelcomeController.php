<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;

class WelcomeController extends Controller
{
    public function index()
    {
        // Ambil semua data partner
        $partners = Partner::all();

        // Kirim data ke halaman welcome
        return view('welcome', compact('partners'));
    }
}