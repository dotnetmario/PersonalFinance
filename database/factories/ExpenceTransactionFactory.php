<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ExpenceTransaction;
use Faker\Generator as Faker;
// "expence", "price", "ref",
$factory->define(ExpenceTransaction::class, function (Faker $faker) {
    return [
        "ref" => ExpenceTransaction::makeRef(),
        "price" => $faker->randomFloat(2, 10, 99999999),
    ];
});
