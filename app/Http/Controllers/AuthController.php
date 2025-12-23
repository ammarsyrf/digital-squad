<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->role === 'talent') {
                return redirect()->intended('/talent/dashboard');
            } elseif ($user->role === 'umkm') {
                return redirect()->intended('/umkm/dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:talent,umkm',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($request->role == 'talent') {
            \App\Models\Talent::create([
                'user_id' => $user->id,
                'nama_lengkap' => $request->nama,
            ]);
        } else {
            \App\Models\Umkm::create([
                'user_id' => $user->id,
                'nama_umkm' => $request->nama,
            ]);
        }

        Auth::login($user);

        // Redirect based on role
        if ($user->role === 'talent') {
            return redirect('/talent/dashboard');
        } else {
            return redirect('/umkm/dashboard');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
