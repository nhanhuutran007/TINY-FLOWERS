<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'barcode', 'name', 'description', 'category_id', 'cost_price', 
        'selling_price', 'material', 'image', 'stock_quantity', 'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://placehold.co/400x400?text=No+Image';
        }

        return asset('images/' . $this->image);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
