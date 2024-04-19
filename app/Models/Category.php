<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'id',
        'name',
        'order',
        'layout',
        'published',
    ];

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }
}
