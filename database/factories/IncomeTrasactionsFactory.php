<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\IncomeTransaction;
use Faker\Generator as Faker;
// "ref", "income", "price",
$factory->define(IncomeTransaction::class, function (Faker $faker) {
    return [
        "ref" => IncomeTransaction::makeRef(),
        "price" => $faker->randomFloat(2, 10, 99999999),
    ];
});
