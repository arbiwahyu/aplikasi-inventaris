<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Location;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ItemsExport;
use App\Imports\ItemsImport;
use App\Exports\ItemFormatExport;
use Illuminate\Database\QueryException;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $items = Item::with(['location', 'category'])->latest()->paginate(10);
        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $locations = Location::all();
        $categories = Category::all();
        return view('items.create', compact('locations', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // 1. Validasi data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'item_code' => 'required|string|max:50|unique:items,item_code',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'purchase_date' => 'required|date',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Opsional, harus gambar, format tertentu, maks 2MB
        ]);

        // 2. Handle upload gambar
        if ($request->hasFile('image')) {
            // Simpan di dalam folder public/item_images dan dapatkan path relatifnya
            $path = $request->file('image')->store('item_images', 'public');
            $validated['image'] = $path;
        }

        // 3. Simpan data ke database
        Item::create($validated);

        // 4. Redirect dengan pesan sukses
        return redirect()->route('items.index')
            ->with('success', 'Barang baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
        $locations = Location::all();
        $categories = Category::all();
        return view('items.edit', compact('item', 'locations', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        //
        // 1. Validasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'item_code' => 'required|string|max:50|unique:items,item_code,' . $item->id,
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'purchase_date' => 'required|date',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. Handle update gambar jika ada gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }

            // Simpan gambar baru dan dapatkan path relatifnya
            $path = $request->file('image')->store('item_images', 'public');
            $validated['image'] = $path;
        }

        // 3. Update data di database
        $item->update($validated);

        return redirect()->route('items.index')->with('success', 'Data barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
        // // Hapus gambar dari storage jika ada
        // if ($item->image) {
        //     $path = str_replace('/storage', 'public', $item->image);
        //     Storage::delete($path);
        // }

        // Hapus data dari database
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Data barang berhasil dihapus.');
    }

    public function borrow(Request $request, Item $item)
    {
        // Pastikan barang tersedia
        if ($item->status != 'Tersedia') {
            return redirect()->back()->with('error', 'Barang ini tidak tersedia untuk dipinjam.');
        }

        // Buat catatan peminjaman baru
        Borrowing::create([
            'item_id' => $item->id,
            'user_id' => Auth::id(), // ID user yang sedang login
            'borrow_date' => now(), // Tanggal hari ini
            'due_date' => now()->addDays(7), // Contoh: batas kembali 7 hari dari sekarang
        ]);

        // Update status barang
        $item->update(['status' => 'Dipinjam']);

        return redirect()->route('items.index')->with('success', 'Barang berhasil dipinjam.');
    }

    public function returnItem(Request $request, Item $item)
    {
        // 1. Cari data peminjaman yang aktif untuk barang ini
        $borrowing = Borrowing::where('item_id', $item->id)
            ->whereNull('return_date') // Cari yang belum dikembalikan
            ->first();

        // 2. Jika tidak ada data peminjaman aktif, kembalikan dengan error
        if (!$borrowing) {
            return redirect()->back()->with('error', 'Barang ini tidak tercatat sedang dipinjam.');
        }

        // 3. Update data peminjaman
        $borrowing->update([
            'return_date' => now(),
            'status' => 'Dikembalikan',
        ]);

        // 4. Update status barang menjadi 'Tersedia'
        $item->update(['status' => 'Tersedia']);

        return redirect()->route('items.index')->with('success', 'Barang berhasil dikembalikan.');
    }

    public function printLabel(Item $item)
    {
        return view('items.label', compact('item'));
    }

    public function export()
    {
        return Excel::download(new ItemsExport, 'daftar-barang.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new ItemsImport, $request->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Ini menangani error validasi dari package (misal: kolom wajib kosong)
            $failures = $e->failures();
            return redirect()->route('items.index')->with('import_errors', $failures);
        } catch (QueryException $e) {
            // Ini menangani error langsung dari database (seperti duplikasi)
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) { // Kode 1062 adalah error spesifik untuk 'Duplicate entry'
                return redirect()->route('items.index')
                    ->with('error', 'Import Gagal! Terdapat duplikasi Kode Barang di dalam file Excel Anda atau kode tersebut sudah ada di sistem.');
            }
            // Untuk error database lainnya
            return redirect()->route('items.index')
                ->with('error', 'Import Gagal! Terjadi kesalahan pada database. Harap Cek Kembali File Import. Pastikan tidak ada kolom yang belum terisi');
        }

        return redirect()->route('items.index')->with('success', 'Data barang berhasil diimpor!');
    }

    public function downloadFormat()
    {
        return Excel::download(new ItemFormatExport, 'format-import-barang.xlsx');
    }
}
