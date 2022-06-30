<?php

namespace App\Repositories\Booking;

use App\Booking;
use App\Helpers\Result;
use App\Repositories\Booking\IBookingRepository;
use Illuminate\Database\Eloquent\Builder;

class BookingRepository implements IBookingRepository
{
    public function store(array $data): Result
    {
        $result = new Result();

        $booking = $this->bookCheck($data);

        if ($booking->exists()) {
            return $result->set(false, 'already exist', [], 422);
        }

        Booking::create($data);

        return $result->set(true, 'success', [], 201);
    }

    public function update(Booking $booking, array $data): Result
    {
        $result = new Result();

        $bookChecking = $this->bookCheck($data);
        $bookToEdit = $bookChecking->get()->first();

        if ($bookChecking->exists() && $bookToEdit->id != $booking->id) {
            return $result->set(false, 'already exist', [], 422);
        }

        $booking->update([
            'user_id' => $data['user_id'],
            'room_id' => $data['room_id'],
            'check_in' => $data['check_in'],
            'check_out' => $data['check_out'],
        ]);

        return $result->set(true, 'success', [], 200);
    }

    public function destroy(Booking $booking): Result
    {
        $result = new Result();

        $booking->delete();

        return $result->set(true, 'successfully deleted booking', [], 204);
    }

    protected function bookCheck($data): Builder
    {
        return Booking::query()
            ->where('room_id', $data['room_id'])
            ->where(function (Builder $query) use ($data) {
                $query->where(function (Builder $q) use ($data) {
                    $q->where('check_in', '<=', $data['check_in'])
                        ->where('check_out', '>=', $data['check_in']);
                })
                    ->orWhere(function (Builder $query) use ($data) {
                        $query->where('check_in', '<=', $data['check_out'])
                            ->where('check_out', '>=', $data['check_out']);
                    });
            });
    }
}
