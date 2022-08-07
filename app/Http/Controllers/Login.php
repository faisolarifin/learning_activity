<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class Login extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('login');
    }
    public function actionLogin(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($data)) {
            return redirect()->route('home');
        }
        return redirect()->route('auth')->with('error', 'Email atau Password Salah!');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth');
    }
}
