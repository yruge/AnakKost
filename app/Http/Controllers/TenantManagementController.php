<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TenantManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Tenant::with(['user', 'room']);

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('phone_number', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('email', 'like', '%' . $search . '%');
                  });
            });
        }

        $tenants = $query->orderBy('created_at', 'desc')->get();
        $availableRooms = Room::where('status', 'available')->get();

        return view('owner.tenants.index', compact('tenants', 'availableRooms'));
    }

    public function store(Request $request)
    {
        // Prevent admin (temporary email-based admin detection) from creating tenants via UI
        if (auth()->check() && auth()->user()->email === 'admin@anak-kost.com') {
            return redirect()->route('owner.tenants.index')->with('error', 'Admins are not allowed to add tenants.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'move_in_date' => 'required|date',
            'ktp_photo' => 'nullable|string',
        ]);

        // Create user account
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make('password'), // Default password
        ]);

        // Create tenant
        Tenant::create([
            'user_id' => $user->id,
            'room_id' => $validated['room_id'],
            'name' => $validated['name'],
            'phone_number' => $validated['phone_number'],
            'ktp_photo' => $validated['ktp_photo'] ?? 'https://via.placeholder.com/640x480.png',
            'move_in_date' => $validated['move_in_date'],
        ]);

        // Update room status
        Room::find($validated['room_id'])->update(['status' => 'occupied']);

        return redirect()->route('owner.tenants.index')->with('success', 'Tenant created successfully');
    }

    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $tenant->user_id,
            'phone_number' => 'required|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'move_in_date' => 'required|date',
        ]);

        // Update user
        $tenant->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // If room changed, update room statuses
        if ($tenant->room_id != $validated['room_id']) {
            Room::find($tenant->room_id)->update(['status' => 'available']);
            Room::find($validated['room_id'])->update(['status' => 'occupied']);
        }

        // Update tenant
        $tenant->update([
            'name' => $validated['name'],
            'phone_number' => $validated['phone_number'],
            'room_id' => $validated['room_id'],
            'move_in_date' => $validated['move_in_date'],
        ]);

        return redirect()->route('owner.tenants.index')->with('success', 'Tenant updated successfully');
    }

    public function destroy(Tenant $tenant)
    {
        // Update room status to available
        Room::find($tenant->room_id)->update(['status' => 'available']);

        // Delete tenant and user
        $tenant->user->delete();
        $tenant->delete();

        return redirect()->route('owner.tenants.index')->with('success', 'Tenant deleted successfully');
    }
}
