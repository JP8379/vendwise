<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'category',
        'product_id',
        'quantity',
        'amount',
        'description',
        'payment_method',
        'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}