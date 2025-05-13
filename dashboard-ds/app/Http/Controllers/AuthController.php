<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        // Validasi input sederhana
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek apakah user ditemukan & password cocok
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Email atau password salah'], 401);
        }

        // // Cek status akun
        // if ($user->status !== 'approved') {
        //     return response()->json(['success' => false, 'message' => 'Akun belum disetujui admin'], 403);
        // }

        //Mengirimkan response Login berhasil
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Login berhasil',
        //     'user' => [
        //         'id' => $user->id,
        //         'email' => $user->email,
        //         'username' => $user->username
        //     ]
        // ]);


        // Login berhasil, set session
        session(['user_id' => $user->id]);

        // Redirect ke halaman dashboard
        return redirect('/dashboard');
    }

    public function dashboard()
    {
        if (!session()->has('user_id')) {
            return redirect('/login');
        }

        // Bisa lanjut
        $user = \App\Models\User::find(session('user_id'));
        return view('dashboard', compact('user'));
    }

    public function logout()
    {
        session()->flush(); // hapus semua session
        return redirect('/login');
    }
}
