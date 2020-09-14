<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OrderProduct;
use Faker\Generator as Faker;

$factory->define(OrderProduct::class, function (Faker $faker) {
    return [
        'order_id' => rand(0,1) && App\Order::find(1) != null
            ? App\Order::find(1)
            : (factory(App\Order::class)),
        'product_id' => rand(0,1) && App\Product::find(1) != null
            ? App\Product::find(1)
            : (factory(App\Product::class)),
        'quantity' => $faker->numberBetween(1,5)
    ];
});
