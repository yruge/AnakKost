<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query();

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where('room_number', 'like', '%' . $request->search . '%');
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $rooms = $query->orderBy('room_number')->get();

        return view('owner.rooms.index', compact('rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'price_per_month' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied',
        ]);

        Room::create($validated);

        return redirect()->route('owner.rooms.index')->with('success', 'Room created successfully');
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'price_per_month' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied',
        ]);

        $room->update($validated);

        return redirect()->route('owner.rooms.index')->with('success', 'Room updated successfully');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('owner.rooms.index')->with('success', 'Room deleted successfully');
    }
}
