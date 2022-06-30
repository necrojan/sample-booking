<?php

namespace Tests\Controller\s\Admin;

use App\Booking;
use App\Room;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BookingsControllerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_see_bookings_page()
    {
        $response = $this->actingAs(factory(User::class)->create())
            ->get('/admin/bookings');

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    /** @test */
    public function it_can_see_list_of_bookings()
    {
        factory(Booking::class, 3)->create();

        $response = $this->actingAs(factory(User::class)->create())
            ->get('/admin/booking-list');

        $data = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $this->assertTrue(count($data) == 3);

    }

    /** @test */
    public function it_can_create_a_booking()
    {
            $user = factory(User::class)->create();
            $room = factory(Room::class)->create();

            $response = $this->actingAs($user)
                ->post('/admin/bookings', [
                    'room_id' => $room->id,
                    'user_id' => $user->id,
                    'check_in' => Carbon::now()->format('YYYY-DD-MM HH:mm:s'),
                    'check_out' => Carbon::now()->addHours()->format('YYYY-DD-MM HH:mm:s')
                ]);

            tap(Booking::latest('id')->first(), function ($booking) use ($response) {
                $this->assertEquals(1, $booking->room_id);
            });
    }

    /** @test */
    public function it_cannot_create_a_booking_if_specified_time_is_taken()
    {
        $userA = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $room = factory(Room::class)->create();

        $now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->format('Y-m-d H:i:s');
        //dd($now);
        $booking = factory(Booking::class)->create([
            'room_id' => $room->id,
            'user_id' => $userA->id,
        ]);
        // dd($booking);
        $response = $this->actingAs($userB)
            ->post('/admin/bookings', [
                'room_id' => $room->id,
                'user_id' => $userB->id,
                'check_in' => $now,
                'check_out' => $now
            ]);

        $data = json_decode($response->getContent(), true);

        $response->assertStatus(422);

        $this->assertTrue('already exist' == $data['message']);
        tap(Booking::latest('id')->first(), function ($booking) use ($userB) {
            $this->assertTrue($booking->user_id != $userB->id);
        });
    }

    /** @test */
    public function it_can_delete_a_booking()
    {
        $booking = factory(Booking::class)->create();

        $response = $this->actingAs(factory(User::class)->create())
            ->delete('/admin/bookings/'.$booking->id);

        $response->assertStatus(204);
    }
}
