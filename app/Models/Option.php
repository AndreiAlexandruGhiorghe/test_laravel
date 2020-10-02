<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orderProduct()
    {
        return $this->hasOne(OrderProduct::class);
    }
}
