<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    public function login()
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                return redirect('/admin')->with('message', 'berhasil login sebagai admin');
            } elseif (Auth::user()->role == 'user') {
                return redirect('/attendance')->with('message', 'berhasil login sebagai user');
            }
        }
        return view('auth.login');
    }

    public function actionLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak terdaftar di sistem',
            'password.required' => 'Password harus diisi'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role == 'admin') {
                return redirect('/admin')->with('message', 'berhasil login sebagai admin');
            } elseif (Auth::user()->role == 'user') {
                return redirect('/attendance')->with('message', 'berhasil login sebagai user');
            }
        } else {
            return back()->withErrors(['email' => 'Email atau password salah, silakan coba lagi'])->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('message', 'berhasil logout');
    }
}
