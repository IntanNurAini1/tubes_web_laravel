<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AkunController extends Controller
{
    private $api = 'http://localhost:3000/akun';
    public function showLogin()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required',
            'username' => 'required',
            'password' => 'required|min:6',
            'confirm' => 'same:password',
        ]);

        // kirim ke API Node.js
        $response = Http::post($this->api . '/register', [
            'nip' => $request->nip,
            'username' => $request->username,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            return redirect()->route('login')
                ->with('success', 'Registrasi berhasil, silakan login');
        }

        return back()->with('error', 'Registrasi gagal');
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $response = Http::post($this->api . '/login', [
            'username' => $request->username,
            'password' => $request->password,
        ]);

        if ($response->successful() && $response->json('success')) {

            Session::put('login', true);
            Session::put('akun', $response->json('data'));

            return redirect()->route('halaman.utama');
        }
        return back()->with('error', 'Username atau password salah');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }
}
