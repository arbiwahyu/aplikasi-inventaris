<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Storage;

class Item extends Model
{
    //
    // app/Models/Item.php
    use HasFactory, LogsActivity;
    //... (di dalam class Item)
    protected $fillable = [
        'category_id',
        'location_id',
        'name',
        'description',
        'image',
        'item_code',
        'purchase_date',
        'status',
        'condition',
    ];
    /**
     * Mendefinisikan relasi "belongsTo" ke model Location.
     * Artinya: Satu Item pasti "milik satu" Location.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Mendefinisikan relasi "belongsTo" ke model Category.
     * Artinya: Satu Item pasti "milik satu" Category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'location.name', 'category.name', 'status', 'condition']) // Catat perubahan pada kolom-kolom ini saja
            ->logOnlyDirty() // Hanya catat jika ada perubahan
            ->setDescriptionForEvent(fn(string $eventName) => "Barang {$this->name} telah di-{$eventName}"); // Deskripsi log
    }

    protected static function booted(): void
    {
        static::deleting(function (Item $item) {
            // Hapus file gambar dari storage jika ada
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
        });
    }
}
