<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $data = Karyawan::all();
        
        // Return JSON dengan Header CORS agar bisa diakses browser
        return response()->json($data)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    public function show($nip)
{
    // Cari karyawan berdasarkan NIP
    $karyawan = Karyawan::where('nip', $nip)->first();

    if ($karyawan) {
        return response()->json($karyawan)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    } else {
        return response()->json(['message' => 'Data tidak ditemukan'], 404)
            ->header('Access-Control-Allow-Origin', '*');
    }
}
}