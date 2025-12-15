<?php
namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    
    public function index()
    {
        return view('user-dashboard', [
            'rooms'  => Room::all(),
            'tenant' => auth()->user()?->tenant,
        ]);
    }
    

}
