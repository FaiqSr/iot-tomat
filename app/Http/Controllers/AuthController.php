<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ====================
    // LOGIN FORM
    // ====================
    public function loginForm()
    {
        return view('page.auth.login'); // resources/views/login.blade.php
    }

    // ====================
    // LOGIN PROCESS
    // ====================
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Email belum terdaftar → redirect ke register
            return redirect()->route('register')->with('info', 'Akun belum ada, silakan register dulu.');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard'); // redirect aman
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    // ====================
    // REGISTER FORM
    // ====================
    public function registerForm()
    {
        return view('page.auth.register'); // resources/views/auth/register.blade.php
    }

    // ====================
    // REGISTER PROCESS
    // ====================
    public function register(Request $request)
    {
        $request->validate([
            'first' => 'required|string|max:255',
            'last' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'sometimes|in:petani,admin' // opsional jika pakai role
        ]);

        User::create([
            'first_name' => $request->first,
            'last_name' => $request->last,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
            'role' => $request->role ?? 'petani'
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat, silakan login.');
    }

    // ====================
    // FORGOT / RESET PASSWORD
    // ====================
    public function forgotForm()
    {
        return view('forgot-password'); // resources/views/auth/forgot-password.blade.php
    }

    public function forgot(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|confirmed'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->with('error','Email tidak ditemukan.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success','Password berhasil diubah, silakan login dengan password baru.');
    }

    // ====================
    // LOGOUT
    // ====================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('info', 'Berhasil logout');
    }
}
