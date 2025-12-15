<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Room;
use Illuminate\Http\Request;

class TenantRegistrationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'phone_number' => 'required',
            'ktp_photo' => 'required|image',
            'move_in_date' => 'required|date',
        ]);

        $room = Room::findOrFail($validated['room_id']);

        if ($room->status !== 'available') {
            return back()->with('error', 'Kamar tidak tersedia.');
        }

        Tenant::create([
            'user_id' => auth()->id(),
            'name' => auth()->user()->name,
            'room_id' => $room->id,
            'phone_number' => $validated['phone_number'],
            'ktp_photo' => $request->file('ktp_photo')->store('ktp', 'public'),
            'move_in_date' => $validated['move_in_date'],
        ]);

        $room->update(['status' => 'occupied']);

        return redirect()->route('tenant.dashboard');
    }


}
