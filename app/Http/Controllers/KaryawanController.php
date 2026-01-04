<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    private $apiUrl = 'http://localhost:3000/api/employees';

    public function index()
    {
        $karyawan = DB::table('karyawan')->get();

        return view('karyawan.index', compact('karyawan'));
    }


    public function store(Request $request)
    {
        Http::post($this->apiUrl, $request->all());

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function show($nip)
    {
        $response = Http::get($this->apiUrl . '/' . $nip);
        $karyawan = $response->json();

        return view('karyawan.show', compact('karyawan'));
    }

    public function update(Request $request, $nip)
    {
        Http::put($this->apiUrl . '/' . $nip, $request->all());

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui');
    }

    public function destroy($nip)
    {
        Http::delete($this->apiUrl . '/' . $nip);

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Karyawan berhasil dihapus');
    }
}
