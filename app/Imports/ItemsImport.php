<?php

namespace App\Imports;

use App\Models\Item;
use App\Models\Category;
use App\Models\Location;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ItemsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty($row['nama_barang'])) {
            return null;
        }

        // Jika kategori kosong, gunakan "Belum Ditentukan", jika tidak, cari atau buat baru.
        $category = !empty($row['kategori'])
            ? Category::firstOrCreate(['name' => $row['kategori']])
            : Category::firstOrCreate(['name' => 'Belum Ditentukan']);

        // Jika lokasi kosong, gunakan "Belum Ditentukan", jika tidak, cari atau buat baru.
        $location = !empty($row['lokasi'])
            ? Location::firstOrCreate(['name' => $row['lokasi']])
            : Location::firstOrCreate(['name' => 'Belum Ditentukan']);

        return new Item([
            'name'           => $row['nama_barang'],
            'item_code'      => $row['kode_barang'],
            'description'    => $row['deskripsi'],
            'purchase_date'  => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_pembelian']),
            // Jika status kosong, gunakan 'Tersedia'.
            'status'         => $row['status'] ?? 'Tersedia',
            // Jika kondisi kosong, gunakan 'Baik'.
            'kondisi'        => $row['kondisi'] ?? 'Baik',
            'category_id'    => $category->id,
            'location_id'    => $location->id,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_barang' => 'required|string',
            'kode_barang' => 'required|string|unique:items,item_code',
            'tanggal_pembelian' => 'required|date',
            // Kolom di bawah ini sekarang boleh kosong (nullable)
            'kategori' => 'nullable|string',
            'lokasi' => 'nullable|string',
            'status' => 'nullable|string',
            'kondisi' => 'nullable|string',
        ];
    }
}
