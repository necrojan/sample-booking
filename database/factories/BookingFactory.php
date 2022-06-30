<?php

/** @var Factory $factory */

use App\Booking;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Booking::class, function (Faker $faker) {
    return [
        'room_id' => function () {
            return \factory(\App\Room::class)->create();
        },
        'user_id' => function () {
            return \factory(\App\User::class)->create();
        },
        'check_in' => Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->format('Y-m-d H:i:s'),
        'check_out' => Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->addHour())->format('Y-m-d H:i:s')
    ];
});
