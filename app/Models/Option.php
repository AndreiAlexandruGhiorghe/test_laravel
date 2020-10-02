<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function contents()
    {
        return $this->hasMany(OptionContent::class);
    }


}
