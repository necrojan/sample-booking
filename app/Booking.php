<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'room_id', 'user_id', 'check_in', 'check_out'
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeInRoom($query, $room)
    {
        return $query->where('room_id', $room);
    }

    public function scopeCheckIn($query, $checkIn)
    {
        return $query->where('check_in', $checkIn);
    }
}
