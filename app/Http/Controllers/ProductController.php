<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB; // WAJIB

class ProductController extends Controller
{
    // private $api = 'http://localhost:3000/api/products';

    // public function index()
    // {
    //     $response = Http::get($this->api);
    //     $products = $response->json();

    //     return view('produk', compact('products'));
    // }

    public function index()
    {
        $products = DB::table('products')->get();

        return view('produk', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => [
                'required',
                'regex:/^P[0-9]{3}$/',
            ],
            'nama_produk' => 'required',
            'jumlah'      => 'required|numeric',
            'status'      => 'required'
        ]);

        $exists = DB::table('products')
            ->where('kode_produk', $request->kode_produk)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['kode_produk' => 'Kode produk tidak boleh sama'])
                ->withInput();
        }

        DB::table('products')->insert([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'jumlah'      => $request->jumlah,
            'status'      => $request->status
        ]);

        return redirect('/produk')->with('success', 'Produk berhasil ditambahkan');
    }

    public function update(Request $request, $kode)
    {
        $request->validate([
            'nama_produk' => 'required',
            'jumlah'      => 'required|numeric',
            'status'      => 'required'
        ]);

        DB::table('products')
            ->where('kode_produk', $kode)
            ->update([
                'nama_produk' => $request->nama_produk,
                'jumlah'      => $request->jumlah,
                'status'      => $request->status
            ]);

        return redirect('/produk')->with('success', 'Produk berhasil diperbarui');
    }

    public function delete($kode)
    {
        DB::table('products')
            ->where('kode_produk', $kode)
            ->delete();

        return redirect('/produk')->with('success', 'Produk berhasil dihapus');
    }
}
