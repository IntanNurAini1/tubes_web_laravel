<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\DB;

class MeetingController extends Controller
{
    private $api;

    public function __construct()
    {
        $this->api = env('MEETING_API_URL', 'http://localhost:3000/meetings');

    }

    public function index()
    {
        $response = Http::get($this->api);

        $meetings = $response->successful()
            ? collect($response->json())
            : collect([]);

        return view('meetings.index', compact('meetings'));
    }

    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'judul' => 'required',
    //         'target_divisi' => 'required',
    //         'tanggal' => 'required|date',
    //         'waktu_mulai' => 'required',
    //         'waktu_selesai' => 'required',
    //         'deskripsi' => 'nullable'
    //     ]);
    //     if ($request->waktu_selesai <= $request->waktu_mulai) {
    //         return back()
    //             ->withInput()
    //             ->with('error', 'Waktu selesai harus lebih besar dari waktu mulai');
    //     }
    //     $response = Http::get($this->api);
    //     $meetings = $response->successful() ? collect($response->json()) : collect([]);

    //     $lastNumber = $meetings->map(function ($m) {
    //         return (int) str_replace('MTG', '', $m['id_meeting']);
    //     })->max();

    //     $nextNumber = $lastNumber ? $lastNumber + 1 : 1; 
    //     $data['id_meeting'] = 'MTG' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    //     $postResponse = Http::post($this->api, $data);

    //     if ($postResponse->successful()) {
    //         return redirect('/meetings')->with('success', 'Meeting berhasil ditambahkan!');
    //     } else {
    //         return redirect('/meetings')->with('error', 'Gagal menambahkan meeting.');
    //     } 
    // }

    // public function update(Request $request, $id)
    // {
    //     $data = $request->validate([
    //         'judul' => 'required',
    //         'target_divisi' => 'required',
    //         'tanggal' => 'required',
    //         'waktu_mulai' => 'required',
    //         'waktu_selesai' => 'required',
    //         'deskripsi' => 'nullable'
    //     ]);
    //     if ($request->waktu_selesai <= $request->waktu_mulai) {
    //         return back()
    //             ->withInput()
    //             ->with('error', 'Waktu selesai harus lebih besar dari waktu mulai');
    //     }
    //     Http::put($this->api . '/' . $id, $data);

    //     return redirect('/meetings');
    // }

    // public function destroy($id)
    // {
    //     Http::delete($this->api . '/' . $id);
    //     return redirect('/meetings');
    // }
    public function store(Request $request)
{
    $data = $request->validate([
        'judul' => 'required',
        'target_divisi' => 'required',
        'tanggal' => 'required|date',
        'waktu_mulai' => 'required',
        'waktu_selesai' => 'required',
        'deskripsi' => 'nullable'
    ]);

    if ($request->waktu_selesai <= $request->waktu_mulai) {
        return back()
            ->withInput()
            ->with('error', 'Waktu selesai harus lebih besar dari waktu mulai');
    }

    $lastMeeting = DB::table('meetings')
        ->select('id_meeting')
        ->orderBy('id_meeting', 'desc')
        ->first();

    $lastNumber = $lastMeeting
        ? (int) str_replace('MTG', '', $lastMeeting->id_meeting)
        : 0;

    $nextNumber = $lastNumber + 1;

    $data['id_meeting'] = 'MTG' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

    DB::table('meetings')->insert($data);

    return redirect('/meetings')
        ->with('success', 'Meeting berhasil ditambahkan!');
}
public function update(Request $request, $id)
{
    $data = $request->validate([
        'judul' => 'required',
        'target_divisi' => 'required',
        'tanggal' => 'required|date',
        'waktu_mulai' => 'required',
        'waktu_selesai' => 'required',
        'deskripsi' => 'nullable'
    ]);

    if ($request->waktu_selesai <= $request->waktu_mulai) {
        return back()
            ->withInput()
            ->with('error', 'Waktu selesai harus lebih besar dari waktu mulai');
    }

    DB::table('meetings')
        ->where('id_meeting', $id)
        ->update($data);

    return redirect('/meetings')
        ->with('success', 'Meeting berhasil diperbarui!');
}
public function destroy($id)
{
    DB::table('meetings')
        ->where('id_meeting', $id)
        ->delete();

    return redirect('/meetings')
        ->with('success', 'Meeting berhasil dihapus!');
}

}
