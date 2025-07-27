<?php

namespace App\Exports;

use App\Models\Location;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ItemFormatExport implements WithHeadings, WithEvents, WithColumnFormatting
{
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'nama_barang',
            'kode_barang',
            'deskripsi',
            'tanggal_pembelian', // <-- Kembalikan ke semula
            'PETUNJUK_TANGGAL (Gunakan format YYYY-MM-DD)', // <-- Tambahkan kolom petunjuk
            'status', // <-- Kembalikan ke semula
            'kondisi', // <-- Kembalikan ke semula
            'kategori',
            'lokasi',
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Ambil semua data untuk dropdown
                $categories = Category::pluck('name')->toArray();
                $locations = Location::pluck('name')->toArray();
                $conditions = ['Baik', 'Rusak Ringan', 'Rusak Berat'];
                $statuses = ['Tersedia', 'Dipinjam', 'Perbaikan'];

                // Terapkan validasi dropdown untuk 1000 baris pertama
                for ($i = 2; $i <= 1001; $i++) {
                    // Dropdown untuk Status (Sekarang di Kolom F)
                    $this->applyDropdown($sheet, "F{$i}", $statuses);
                    // Dropdown untuk Kondisi (Sekarang di Kolom G)
                    $this->applyDropdown($sheet, "G{$i}", $conditions);
                    // Dropdown untuk Kategori (Sekarang di Kolom H)
                    $this->applyDropdown($sheet, "H{$i}", $categories);
                    // Dropdown untuk Lokasi (Sekarang di Kolom I)
                    $this->applyDropdown($sheet, "I{$i}", $locations);
                }
            },
        ];
    }

    /**
     * Helper function untuk menerapkan validasi dropdown
     */
    private function applyDropdown($sheet, $cellCoordinate, $options)
    {
        $validation = $sheet->getCell($cellCoordinate)->getDataValidation();
        $validation->setType(DataValidation::TYPE_LIST);
        $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
        $validation->setAllowBlank(true);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        $validation->setFormula1('"' . implode(',', $options) . '"');
    }

    public function columnFormats(): array
    {
        return [
            // Format kolom 'D' sebagai Tanggal YYYY-MM-DD
            'D' => NumberFormat::FORMAT_DATE_YYYYMMDD,
        ];
    }
}
