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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        // Create User
        User::create([
            'name' => $validated['name'],  // bisa ambil dari tenant name
            'email' => $validated['email'],
            'password' => $validated['password'],
            'email_verified_at' => now(),
        ]);

        return redirect('/login')
            ->with('success', 'Registration successful! Please login.');
    }
}
