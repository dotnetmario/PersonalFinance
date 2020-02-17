<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Expence;
use Faker\Generator as Faker;
// "user", "name", "steady", "pay_schedule", "pay_date", "tax", "description",
$factory->define(Expence::class, function (Faker $faker) {
    $steady = rand(0,1) == 1;
    $schedule = config("site.Expences.pay_schedule");

    if($steady){
        $pay_schedule = $schedule[rand(0,4)];
        $pay_date = $faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now', $timezone = null);
    }else{
        $pay_schedule = null;
        $pay_date = null;
    }

    return [
        'name' => $faker->word,
        'steady' => rand(0,1) == 1,
        'pay_schedule' => $pay_schedule,
        'pay_date' => $pay_date,
        'tax' => $faker->numberBetween(1, 45),
        'description' => $faker->paragraph(3, true),
    ];
});
