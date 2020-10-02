<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    public function option()
    {
        return $this->hasOne(Option::class);
    }
}
