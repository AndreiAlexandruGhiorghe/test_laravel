<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->paragraph,
        'price' => $faker->numberBetween(100, 1000),
        'inventory' => $faker->numberBetween(1, 1000),
        'image_path' => $faker->sentence
    ];
});
