<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'phone', 'address', 'total_spent'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
