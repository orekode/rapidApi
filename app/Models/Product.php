<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Abbasudo\Purity\Traits\Filterable;

class Product extends Model
{
    use HasFactory, Filterable;

    protected $guarded = ['created_at', 'updated_at', 'id'];

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product');
    }
}
