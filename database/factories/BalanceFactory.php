<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Balance;
use Faker\Generator as Faker;

$factory->define(Balance::class, function (Faker $faker) {
    return [
        'last_income_trans' => 1,
        'last_expence_trans' => 1,
        'balance' => $faker->randomFloat(2, 10, 99999999),
    ];
});
