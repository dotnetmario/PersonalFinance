<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

// 'firstname', 'lastname', 'email', 'phone', 'birthday', 'photo', 'bio', 'password',
$factory->define(User::class, function (Faker $faker) {
    return [
        'firstname' => $faker->name,
        'lastname' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'birthday' => $faker->date('Y-m-d', $max = 'now'),
        'photo' => null,
        'bio' => null,
        'password' => Hash::make("123456789"),
    ];
});
