<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\IncomePrice;
use Faker\Generator as Faker;
// "income", "price", "active",
$factory->define(IncomePrice::class, function (Faker $faker) {
    return [
        "price" => $faker->randomFloat(2, 10, 99999999),
        "active" => rand(0,1) == 1,
    ];
});
