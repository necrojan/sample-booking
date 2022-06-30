<?php

use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $july7 = \Carbon\Carbon::create(2022, 7, 7, 9);
        $july8 = \Carbon\Carbon::create(2022, 7, 8, 8);
        $july9 = \Carbon\Carbon::create(2022, 7, 9, 8);

        factory(\App\Booking::class)->create([
            'room_id' => 2,
            'user_id' => 2,
            'check_in' => $july7->toDateTimeString(),
            'check_out' => $july7->addHours(1)
        ]);

        factory(\App\Booking::class)->create([
            'room_id' => 2,
            'user_id' => 2,
            'check_in' => $july8->toDateTimeString(),
            'check_out' => $july8->addHours(1)
        ]);

        factory(\App\Booking::class)->create([
            'room_id' => 1,
            'user_id' => 3,
            'check_in' => $july9->toDateTimeString(),
            'check_out' => $july9->addHours(1)
        ]);
    }
}
