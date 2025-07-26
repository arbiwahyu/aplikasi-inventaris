<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
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
}
