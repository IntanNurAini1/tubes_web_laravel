<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class LogistikController extends Controller
{
    private $api = 'http://localhost:3000/api/logistik';

    public function index()
    {
        $response = Http::get($this->api);
        $logistik = $response->json();

        return view('logistik', compact('logistik'));
    }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'kode'   => 'required',
//             'nama'   => 'required',
//             'jumlah' => 'required|numeric',
//             'status' => 'required',
//             'harga'  => 'required|numeric'
//         ]);

//         Http::post($this->api, $request->all());

//         return redirect('/logistik');
//     }

//     public function update(Request $request, $id)
//     {
//         $request->validate([
//             'kode'   => 'required',
//             'nama'   => 'required',
//             'jumlah' => 'required|numeric',
//             'status' => 'required',
//             'harga'  => 'required|numeric'
//         ]);

//         Http::put($this->api.'/'.$id, $request->all());

//         return redirect('/logistik');
//     }

//     public function destroy($id)
// {
//     $response = Http::delete($this->api . '/' . $id);

//     if ($response->successful()) {
//         return response()->json(['success' => true]);
//     }

//     return response()->json(['success' => false], 500);
// }
public function store(Request $request)
    {
        $request->validate([
            'kode'   => 'required',
            'nama'   => 'required',
            'jumlah' => 'required|numeric',
            'status' => 'required',
            'harga'  => 'required|numeric'
        ]);

        DB::table('logistik')->insert([
            'kode'   => $request->kode,
            'nama'   => $request->nama,
            'jumlah' => $request->jumlah,
            'status' => $request->status,
            'harga'  => $request->harga,
            // 'created_at' => now(),
            // 'updated_at' => now(),
        ]);

        return redirect('/logistik')->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode'   => 'required',
            'nama'   => 'required',
            'jumlah' => 'required|numeric',
            'status' => 'required',
            'harga'  => 'required|numeric'
        ]);

        DB::table('logistik')
            ->where('id', $id)
            ->update([
                'kode'   => $request->kode,
                'nama'   => $request->nama,
                'jumlah' => $request->jumlah,
                'status' => $request->status,
                'harga'  => $request->harga,
                // 'updated_at' => now(),
            ]);

        return redirect('/logistik')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $deleted = DB::table('logistik')->where('id', $id)->delete();

        if ($deleted) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 500);
    }
}