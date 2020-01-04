<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Income;
//    "user", "name", "amount", "steady", "pay_schedule", "payday", "tax", "description",
$factory->define(Income::class, function (Faker $faker) {
    return [
        'user' => rand(1, 12),
        'name' => $faker->word,
        'amount' => $faker->randomFloat(null, 500, 70000),
        'steady' => true,
        'pay_schedule' => null,
        'payday' => null,
        'tax' => $faker->numberBetween(1, 45),
        'description' => $faker->paragraph(3, true),
    ];
});
