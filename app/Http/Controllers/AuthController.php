<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Kalau sudah login, arahkan sesuai role
        if (Auth::check()) {
            return redirect($this->redirectByRole());
        }

        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username harus diisi',
            'password.required' => 'Password harus diisi'
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
            'status'   => 'aktif'
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                'success'  => true,
                'message'  => 'Login berhasil!',
                'redirect' => $this->redirectByRole()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Username atau password salah!'
        ], 401);
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('logout', 'Logout berhasil!');

    }

    /**
     * Redirect sesuai hak akses user
     */
    private function redirectByRole()
    {
        if (Auth::user()->hak_akses === 'admin') {
            return route('admin.dashboard');
        }

        return route('guru.dashboard');
    }
}
