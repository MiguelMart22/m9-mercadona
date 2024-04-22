<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\ProductObserver;

class Product extends Model
{

    protected static function boot()
    {
        parent::boot();
        Product::observe(ProductObserver::class);
    }


    protected $fillable = [
        'id',
        'limit',
        'packaging',
        'thumbnail',
        'display_name',
        'unit_price',
        'subcategory_id', 
    ];

    protected $casts = [
        'id' => 'double', 
        'unit_price' => 'decimal:2', 

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
