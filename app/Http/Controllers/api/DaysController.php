<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\Days;
use Illuminate\Routing\Controller;

class DaysController extends Controller
{
    // Menampilkan semua data dengan relasi merchant_operational_times
    public function index()
    {
        $days = Days::with('merchantOperationalTimes')->get();
        return response()->json($days);
    }

    // Menampilkan data berdasarkan ID dengan relasi merchant_operational_times
    public function show($id)
    {
        $day = Days::with('merchantOperationalTimes')->find($id);
        if (!$day) {
            return response()->json(['message' => 'Data not found'], 404);
        }
        return response()->json($day);
    }

    // Menambahkan data baru
    public function store(Request $request)
    {
        // Validasi input jika diperlukan
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Membuat data baru
        $day = Days::create([
            'name' => $request->input('name'),
        ]);

        return response()->json($day, 201); // Mengembalikan data yang baru dibuat dengan status 201
    }

    // Memperbarui data berdasarkan ID
    public function update(Request $request, $id)
    {
        // Menemukan data berdasarkan ID
        $day = Days::find($id);
        if (!$day) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        // Validasi input jika diperlukan
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Memperbarui data
        $day->update([
            'name' => $request->input('name'),
        ]);

        return response()->json($day); // Mengembalikan data yang telah diperbarui
    }

    // Menghapus data berdasarkan ID
    public function destroy($id)
    {
        // Menemukan data berdasarkan ID
        $day = Days::find($id);
        if (!$day) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        // Menghapus data
        $day->delete();

        return response()->json(['message' => 'Data deleted successfully']); // Mengembalikan pesan sukses
    }
}
