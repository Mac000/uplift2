<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Delivery;

$factory->define(Delivery::class, function (Faker $faker) {
    return [
        'receiver' => $faker->name,
        'address' => $faker->address,
        'phone_no' => $faker->shuffle('03036045601'),
        'goods' => $faker->text($maxNbChars = 30),
        'gps' => $faker->shuffle('40.741895,-73.989308'),
        'cost' => $faker->numberBetween(100, 15000),
        'user_id' => $faker->numberBetween(1,3),
        'tehsil' => $faker->state,
        'cnic' => $faker->shuffle('3420185678399'),
        'image' => $faker->image($dir = 'storage'),

    ];
});
