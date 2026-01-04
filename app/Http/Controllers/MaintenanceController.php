<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;


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

        //query builder
         $exists = DB::table('maintenance_alat')
        ->where('id_alat', $request->id_alat)
        ->exists();

        if ($exists) {
            return back()
                ->withErrors(['id_alat' => 'Kode alat tidak boleh sama'])
                ->withInput();
        }

        DB::table('maintenance_alat')->insert([
            'id_alat' => $request->id_alat,
            'nama_alat' => $request->nama_alat,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ]);
        return redirect('/maintenance');

        //api nodejs
        // $maintenances = Http::get($this->api)->json();

        // $exists = collect($maintenances)
        //             ->contains('id_alat', $request->id_alat);

        // if ($exists) {
        //     return back()
        //         ->withErrors(['id_alat' => 'Kode alat tidak boleh sama'])
        //         ->withInput();
        // }

        // $response = Http::post($this->api, [
        //     'id_alat' => $request->id_alat,
        //     'nama_alat' => $request->nama_alat,
        //     'deskripsi'   => $request->deskripsi,
        //     'status'    => $request->status
        // ]);

        // if (!$response->successful()) {
        //     return back()->withErrors(['api' => 'Gagal mengirim ke API Node']);
        // }

        // return redirect('/maintenance');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_alat' => 'required',
            'deskripsi'   => 'required',
            'status'    => 'required'
        ]);

        //query builder
        DB::table('maintenance_alat')
        ->where('id_alat', $id)
        ->update([
            'nama_alat' => $request->nama_alat,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ]);

        return redirect('/maintenance');

        //api nodejs
        // Http::put($this->api.'/'.$id, [
        //     'nama_alat' => $request->nama_alat,
        //     'deskripsi'   => $request->deskripsi,
        //     'status'    => $request->status
        // ]);

        // return redirect('/maintenance');
    }

    public function delete($id)
    {
        //query builder
         DB::table('maintenance_alat')
        ->where('id_alat', $id)
        ->delete();

        return redirect('/maintenance');

        //api nodejs
        // Http::delete($this->api.'/'.$id);
        // return redirect('/maintenance');
    }
}
