<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\EventsController;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([

            'email'=>['required','email'],

            'password'=>['required'],

        ]);

        if(Auth::attempt($credentials)){

            $request->session()->regenerate();

            return redirect()->route('admin.categories.index');

        }

        return back()->withErrors([

            'email'=>'Email atau Password salah.'

        ])->onlyInput('email');
    }

   public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect()->route('admin.login');
}
}