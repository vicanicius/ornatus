<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;

$factory->define(OrderProduct::class, function (Faker\Generator $faker) {
    return [
        'product_id' => factory(Product::class)->create()->id,
        'order_id' => factory(Order::class)->create()->id,
        'quantity' => $faker->randomFloat(),
        'amount' => $faker->randomFloat(),
    ];
});