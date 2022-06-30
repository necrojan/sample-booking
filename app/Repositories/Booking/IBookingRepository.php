<?php

namespace App\Repositories\Booking;

use App\Booking;
use App\Helpers\Result;

interface IBookingRepository
{
    public function store(array $data): Result;

    public function update(Booking $booking, array $data): Result;

    public function destroy(Booking $booking): Result;
}
