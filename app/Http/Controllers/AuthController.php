<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        $request->validate([
            'nis' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan NIS
        $user = User::where('nis', $request->nis)->first();

        if (!$user) {
            return back()->with('error', 'NIS tidak ditemukan!');
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah!');
        }

        // Login
        Auth::login($user);

        // Redirect berdasarkan role
        if ($user->role == 'admin') {
            return redirect()->route('dashboard')->with('success', 'Selamat datang Admin!');
        } elseif ($user->role == 'kepsek') {
            return redirect()->route('dashboard')->with('success', 'Selamat datang Kepala Sekolah!');
        } else {
            return redirect()->route('dashboard')->with('success', 'Selamat datang Guru!');
        }
    }

    /**
     * Proses logout
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }
}