<?php

/** @var Factory $factory */

use App\Room;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Room::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['Luxury Suite', 'Suite', 'Economy']),
        'description' => $faker->text
    ];
});
