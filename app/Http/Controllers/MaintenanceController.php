<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MaintenanceController extends Controller
{
    private $api = 'http://localhost:3000/api/maintenance';

    public function index()
    {
        $response = Http::get($this->api);
        $maintenances = $response->json();

        return view('maintenance', compact('maintenances'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_alat' => 'required',
            'nama_alat' => 'required',
            'deskripsi'   => 'required',
            'status'    => 'required'
        ]);

        // GET semua data
        $maintenances = Http::get($this->api)->json();

        // Cek apakah kode sudah ada
        $exists = collect($maintenances)
                    ->contains('id_alat', $request->id_alat);

        if ($exists) {
            return back()
                ->withErrors(['id_alat' => 'Kode alat tidak boleh sama'])
                ->withInput();
        }

        // Kirim ke Node
        $response = Http::post($this->api, [
            'id_alat' => $request->id_alat,
            'nama_alat' => $request->nama_alat,
            'deskripsi'   => $request->deskripsi,
            'status'    => $request->status
        ]);

        // Kalau gagal tampilkan error
        if (!$response->successful()) {
            return back()->withErrors(['api' => 'Gagal mengirim ke API Node']);
        }

        return redirect('/maintenance');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_alat' => 'required',
            'deskripsi'   => 'required',
            'status'    => 'required'
        ]);

        Http::put($this->api.'/'.$id, [
            'nama_alat' => $request->nama_alat,
            'deskripsi'   => $request->deskripsi,
            'status'    => $request->status
        ]);

        return redirect('/maintenance');
    }

    public function delete($id)
    {
        Http::delete($this->api.'/'.$id);
        return redirect('/maintenance');
    }
}
