<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    // app/Models/Item.php

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
}
