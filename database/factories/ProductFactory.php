<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'price' => $faker->randomFloat(),
        'store_id' => factory(\App\Models\Store::class)->create()->id,
        'active' => $faker->boolean,
    ];
});
