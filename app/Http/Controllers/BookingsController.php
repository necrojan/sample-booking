<?php

namespace App\Http\Controllers;

use App\Booking;

class BookingsController
{
    public function index()
    {
        return view('bookings');
    }

    public function list()
    {
        return Booking::with('room')
            ->with('user')
            ->get();
    }
}
