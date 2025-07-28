<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Team;
use App\Models\Branch;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::with(['branch.team', 'roomType'])
            ->orderBy('branch_id')
            ->paginate(10);

        return view('livewire.pages.rooms.index', compact('rooms'));
    }

    public function show(Team $hotel, Branch $branch, Room $room)
    {
        $room->load('roomType', 'branch.team');

        $rooms = $branch->rooms()
            ->with('roomType')
            ->paginate(6);

        $basePrice = $room->roomType->price;
        $nightsDefault = 1;

        return view('livewire.pages.rooms.show', compact('hotel', 'branch', 'room', 'rooms', 'basePrice', 'nightsDefault'));
    }
}

