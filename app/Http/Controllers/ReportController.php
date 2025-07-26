<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Location;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function itemReport(Request $request)
    {
        // Ambil semua lokasi untuk pilihan filter dropdown
        $locations = Location::all();

        // Mulai query builder untuk Item
        $query = Item::query()->with(['location', 'category']);

        // Filter berdasarkan lokasi jika ada
        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        // Filter berdasarkan rentang tanggal pembelian jika ada
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('purchase_date', [$request->start_date, $request->end_date]);
        }

        // Eksekusi query dan ambil hasilnya
        $items = $query->get();

        // Kirim data ke view
        return view('reports.items', compact('items', 'locations'));
    }

    public function availability(Request $request)
    {
        $items = collect(); // Buat koleksi kosong secara default

        // Hanya jalankan query jika ada input tanggal
        if ($request->filled('check_date')) {
            $targetDate = $request->check_date;

            // Ambil semua barang yang TIDAK MEMILIKI peminjaman aktif pada tanggal tersebut
            $items = Item::whereDoesntHave('borrowings', function ($query) use ($targetDate) {
                $query->where('borrow_date', '<=', $targetDate)
                    ->where('due_date', '>=', $targetDate)
                    ->whereNull('return_date');
            })->get();
        }

        return view('reports.availability', compact('items'));
    }
}
