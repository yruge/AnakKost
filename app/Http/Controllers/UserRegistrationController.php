<?php
namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use App\Models\Room;
use Illuminate\Http\Request;

class UserRegistrationController extends Controller
{
    public function showForm()
    {
        // $rooms = Room::where('status', 'available')->get();
        // return view('register-tenant', compact('rooms'));
        return view('register-user');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Tenant Data
            // 'phone_number' => 'required|max:20',
            // 'ktp_photo' => 'required|image',
            
            // User Account
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        // Upload KTP
        // $path = $request->file('ktp_photo')->store('ktp', 'public');

        // Create User
        User::create([
            'name' => $validated['name'],  // bisa ambil dari tenant name
            'email' => $validated['email'],
            'password' => $validated['password'],
            'email_verified_at' => now(),
        ]);

        // Create Tenant
        // $tenant = Tenant::create([
        //     'user_id' => $user->id,
        //     'name' => $validated['name'],
        //     'phone_number' => $validated['phone_number'],
        //     'ktp_photo' => $path,
        // ]);

        return redirect('/login')
            ->with('success', 'Registration successful! Please login.');
    }
}
