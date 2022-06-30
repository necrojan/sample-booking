<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Room;

class RoomsController extends Controller
{
    public function list()
    {
        return Room::all();
    }
}
