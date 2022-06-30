<?php

use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = [
            ['name' => 'Luxury Suite', 'description' => '3 king sized bed, full kitchen.'],
            ['name' => 'Double', 'description' => 'Two queen sized bed.'],
            ['name' => 'Economy', 'description' => 'One queen bed with small fridge.'],
        ];

        foreach ($rooms as $room) {
            factory(\App\Room::class)->create([
                'name' => $room['name'],
                'description' => $room['description']
            ]);
        }
    }
}
