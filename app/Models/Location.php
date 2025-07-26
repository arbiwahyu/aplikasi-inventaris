<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [ // <-- TAMBAHKAN INI
        'name',
        'description',
    ];
    //
    // app/Models/Location.php

    //... (di dalam class Location)

    /**
     * Mendefinisikan relasi "hasMany" ke model Item.
     * Artinya: Satu Lokasi bisa "memiliki banyak" Item.
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
