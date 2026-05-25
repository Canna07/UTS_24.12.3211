<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;

class HomeController extends Controller
{
    public function index()
    {
        $partners = Partner::all();

        return view('welcome', compact('partners'));
    }
}