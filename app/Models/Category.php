<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Category extends Model
{
    use HasFactory, LogsActivity;
    //
    // app/Models/Category.php
    protected $fillable = ['name'];
    //... (di dalam class Category)

    /**
     * Mendefinisikan relasi "hasMany" ke model Item.
     * Artinya: Satu Kategori bisa "memiliki banyak" Item.
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Kategori {$this->name} telah di-{$eventName}");
    }
}
