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

        $moveInDate = Carbon::parse($tenant->move_in_date)->startOfDay();
        $today = Carbon::today();

        $periodStart = $moveInDate->copy();
        while ($periodStart->copy()->addMonthNoOverflow()->lte($today)) {
            $periodStart->addMonthNoOverflow();
        }

        $nextPaymentDate = $periodStart->copy()->addMonthNoOverflow();

        $nextPaymentDateFormatted = $nextPaymentDate->translatedFormat('d F Y');

        return view('tenant-dashboard', compact(
            'tenant',
            'room',
            'monthlyPrice',
            'nextPaymentDateFormatted'
        ));
    }

}
