<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'barcode', 'name', 'category_id', 'cost_price', 
        'selling_price', 'material', 'image', 'stock_quantity', 'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
