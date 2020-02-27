<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Variation;
use Faker\Generator as Faker;

$factory->define(Variation::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
        'increased_amount' => $faker->randomFloat(null, 10, 30),
    ];
});
