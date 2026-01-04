<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KaryawanController extends Controller
{
    private $apiUrl = 'http://localhost:3000/api/employees';

    /**
     * Tampilkan daftar karyawan (CARD GRID)
     */
    public function index()
    {
        $response = Http::get($this->apiUrl);
        $karyawan = $response->json();

        return view('karyawan.index', compact('karyawan'));
    }

    /**
     * Simpan karyawan baru (dipanggil dari POPUP di index)
     */
    public function store(Request $request)
    {
        Http::post($this->apiUrl, $request->all());

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Karyawan berhasil ditambahkan');
    }

    /**
     * Detail karyawan (klik CARD)
     */
    public function show($nip)
    {
        $response = Http::get($this->apiUrl . '/' . $nip);
        $karyawan = $response->json();

        return view('karyawan.show', compact('karyawan'));
    }

    /**
     * Update karyawan (POPUP EDIT di index)
     */
    public function update(Request $request, $nip)
    {
        Http::put($this->apiUrl . '/' . $nip, $request->all());

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui');
    }

    /**
     * Hapus karyawan (POPUP KONFIRMASI di index)
     */
    public function destroy($nip)
    {
        Http::delete($this->apiUrl . '/' . $nip);

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Karyawan berhasil dihapus');
    }
}
