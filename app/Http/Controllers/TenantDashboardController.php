<?php
namespace App\Http\Controllers;

use Carbon\Carbon;

class TenantDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $tenant = $user->tenant;

        if (!$tenant) {
            return redirect()
                ->route('user.dashboard')
                ->with('error', 'Anda belum terdaftar sebagai tenant.');
        }

        if (!$tenant->room || !$tenant->move_in_date) {
            return view('user-dashboard', compact('tenant'));
        }

        $room = $tenant->room;
        $monthlyPrice = $room->price_per_month;

        $moveInDate = Carbon::parse($tenant->move_in_date);
        $nextPaymentDate = $moveInDate->copy()->addMonths(now()->diffInMonths($moveInDate) + 1);

        $daysLeft = now()->diffInDays($nextPaymentDate, false);
        $progress = max(0, min(100, 100 - ($daysLeft * 3)));

        return view('tenant-dashboard', compact(
            'tenant',
            'room',
            'monthlyPrice',
            'nextPaymentDate',
            'daysLeft',
            'progress'
        ));
    }

}
