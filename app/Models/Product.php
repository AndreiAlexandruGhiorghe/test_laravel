<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['title', 'description', 'price', 'image_path', 'inventory'];

    public function scopeProductsOutsideCart($query, $myCart)
    {
        // building the query for the products from cart that
        $params = [];
        $queryString = 'inventory > CASE ';
        foreach ($myCart as $idProduct => $quantity) {
            $queryString .= 'WHEN id = ? THEN ? ';
            $params[] = $idProduct;
            $params[] = $quantity;
        }
        $queryString .= ' END';

        // get the data from the table
        $query->select('*')
            ->whereNotIn('id', array_keys($myCart))
            ->orWhereRaw($queryString, $params)
            ->get();
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, OrderProduct::class)->withPivot(['quantity']);
    }
}
