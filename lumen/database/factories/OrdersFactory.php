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

$factory->define(Order::class, function (Faker\Generator $faker) {
    return [
        'amount' => $faker->randomFloat(2, 0, 8)
    ];
});