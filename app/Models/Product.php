<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'stock_quantity',
        'low_stock_threshold',
        'price',
        'category',
        'product_date',
        'description',
    ];

    protected $casts = [
        'product_date' => 'date',
    ];
}