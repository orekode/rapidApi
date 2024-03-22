<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id, created_at, updated_at'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products', 'order', 'product')->withPivot('quantity as order_quantity');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
