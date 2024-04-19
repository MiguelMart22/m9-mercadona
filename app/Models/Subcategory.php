<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = [
        'id',
        'name',
        'order',
        'layout',
        'published',
        'is_extended',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
