<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Tenant;
use App\Models\Payment;
use Illuminate\Http\Request;

class OwnerDashboardController extends Controller
{
    public function index(Request $request)
    {
        // KPIs
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $availableRooms = Room::where('status', 'available')->count();
        $totalTenants = Tenant::count();
        
        // Recent activity
        $recentTenants = Tenant::with('room', 'user')
            ->latest()
            ->take(5)
            ->get();
        
        $recentPayments = Payment::with('tenant')
            ->latest('payment_date')
            ->take(5)
            ->get();
        
        // Financial summary
        $monthlyRevenue = Payment::whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount');

        return view('owner.dashboard', compact(
            'totalRooms',
            'occupiedRooms',
            'availableRooms',
            'totalTenants',
            'recentTenants',
            'recentPayments',
            'monthlyRevenue'
        ));
    }
}
