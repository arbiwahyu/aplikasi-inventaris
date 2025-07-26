<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data lokasi dari database, urutkan dari yang terbaru
        $locations = Location::latest()->paginate(10);

        // Kirim data ke view
        return view('locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('locations.create'); // Kita perintahkan untuk menampilkan view create.blade.php
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // Langkah 1: Validasi input form
        $request->validate([
            'name' => 'required|string|max:100|unique:locations,name', // Wajib diisi, harus teks, maks 100 char, tidak boleh sama dengan yg sudah ada di tabel locations
            'description' => 'nullable|string', // Boleh kosong, jika diisi harus teks
        ]);

        // Langkah 2: Jika validasi berhasil, simpan data ke database
        Location::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Langkah 3: Redirect (alihkan) pengguna kembali ke halaman daftar lokasi
        // dengan membawa pesan sukses
        return redirect()->route('locations.index')
            ->with('success', 'Lokasi baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        //
        // Laravel secara otomatis akan mencari data lokasi berdasarkan ID dari URL
        // dan mengirimkannya ke view 'locations.edit'
        return view('locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        //
        // Langkah 1: Validasi input form
        $request->validate([
            'name' => 'required|string|max:100|unique:locations,name,' . $location->id,
            'description' => 'nullable|string',
        ]);

        // Langkah 2: Jika validasi berhasil, update data di database
        $location->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Langkah 3: Redirect kembali ke halaman daftar lokasi dengan pesan sukses
        return redirect()->route('locations.index')
            ->with('success', 'Data lokasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        //
        // Langkah 1: Hapus data dari database
        $location->delete();

        // Langkah 2: Redirect kembali ke halaman daftar lokasi dengan pesan sukses
        return redirect()->route('locations.index')
            ->with('success', 'Data lokasi berhasil dihapus.');
    }
}
