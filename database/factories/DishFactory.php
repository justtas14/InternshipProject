<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Dish;
use Faker\Generator as Faker;

$factory->define(Dish::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'price' => $faker->randomFloat(null, 10, 100),
        'is_out_of_stock' => $faker->boolean,
        'description' => $faker->text(100),
        'profile_picture' => 'initial'
    ];
});
