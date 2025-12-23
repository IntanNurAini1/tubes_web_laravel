<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    private $api = 'http://localhost:3000/api/products';

    public function index()
    {
        $response = Http::get($this->api);
        $products = $response->json();

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

        $products = Http::get($this->api)->json();

        $exists = collect($products)
            ->contains('kode_produk', $request->kode_produk);

        if ($exists) {
            return back()
                ->withErrors(['kode_produk' => 'Kode produk tidak boleh sama'])
                ->withInput();
        }

        Http::post($this->api, [
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'jumlah'      => $request->jumlah,
            'status'      => $request->status
        ]);

        return redirect('/');
    }

    public function update(Request $request, $kode)
    {
        $request->validate([
            'nama_produk' => 'required',
            'jumlah'      => 'required|numeric',
            'status'      => 'required'
        ]);

        Http::put($this->api.'/'.$kode, [
            'nama_produk' => $request->nama_produk,
            'jumlah'      => $request->jumlah,
            'status'      => $request->status
        ]);

        return redirect('/');
    }

    public function delete($kode)
    {
        Http::delete($this->api.'/'.$kode);
        return redirect('/');
    }
}
