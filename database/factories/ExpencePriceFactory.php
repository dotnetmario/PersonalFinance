<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ExpencePrice;
use Faker\Generator as Faker;
// "expence", "price", "active",
$factory->define(ExpencePrice::class, function (Faker $faker) {
    return [
        "price" => $faker->randomFloat(2, 10, 99999999),
        "active" => rand(0,1) == 1,
    ];
});
