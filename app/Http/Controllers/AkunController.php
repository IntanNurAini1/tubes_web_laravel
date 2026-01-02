<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AkunController extends Controller
{
    // BASE URL API NODE.JS
    private $api = 'http://localhost:3000/akun';

    // ===============================
    // TAMPILKAN HALAMAN LOGIN
    // ===============================
    public function showLogin()
    {
        return view('login');
    }

    // ===============================
    // PROSES LOGIN (CALL API NODE)
    // ===============================
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // KIRIM KE NODE.JS
        $response = Http::post($this->api . '/login', [
            'username' => $request->username,
            'password' => $request->password,
        ]);

        // JIKA LOGIN BERHASIL
        if ($response->successful() && $response->json('success')) {

            Session::put('login', true);
            Session::put('akun', $response->json('data'));

            return redirect()->route('halaman.utama');
        }

        // JIKA GAGAL
        return back()->with('error', 'Username atau password salah');
    }

    // ===============================
    // LOGOUT
    // ===============================
    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }
}
