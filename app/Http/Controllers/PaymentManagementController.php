<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentManagementController extends Controller
{
    public function index(Request $request)
    {
        // Get all tenants with their latest payment
        $tenants = Tenant::with(['room', 'user', 'payments' => function($query) {
            $query->latest('payment_date');
        }])->get();

        // Calculate overdue tenants
        $overdueTenants = [];
        foreach ($tenants as $tenant) {
            $lastPayment = $tenant->payments->first();
            
            if ($lastPayment) {
                $nextDueDate = Carbon::parse($lastPayment->payment_date)->addMonth();
            } else {
                $nextDueDate = Carbon::parse($tenant->move_in_date)->addMonth();
            }

            $daysOverdue = now()->diffInDays($nextDueDate, false);
            
            if ($daysOverdue < 0) {
                $overdueTenants[] = [
                    'tenant' => $tenant,
                    'last_payment' => $lastPayment,
                    'next_due_date' => $nextDueDate,
                    'days_overdue' => abs($daysOverdue),
                    'amount_due' => $tenant->room->price_per_month
                ];
            }
        }

        // Payment history with filters
        $query = Payment::with(['tenant.room', 'tenant.user']);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('tenant', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhereHas('room', function($roomQuery) use ($search) {
                      $roomQuery->where('room_number', 'like', '%' . $search . '%');
                  });
            });
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('month') && $request->month) {
            $date = Carbon::parse($request->month);
            $query->whereMonth('payment_date', $date->month)
                  ->whereYear('payment_date', $date->year);
        }

        $payments = $query->orderBy('payment_date', 'desc')->paginate(20);

        // Stats
        $totalCollected = Payment::where('status', 'paid')
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount');

        $totalPending = count($overdueTenants) * ($tenants->first()->room->price_per_month ?? 0);

        return view('owner.payments.index', compact(
            'overdueTenants',
            'payments',
            'totalCollected',
            'totalPending',
            'tenants'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'for_period' => 'required|string',
            'status' => 'required|in:paid,pending,failed',
        ]);

        Payment::create($validated);

        return redirect()->route('owner.payments.index')->with('success', 'Payment recorded successfully');
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'for_period' => 'required|string',
            'status' => 'required|in:paid,pending,failed',
        ]);

        $payment->update($validated);

        return redirect()->route('owner.payments.index')->with('success', 'Payment updated successfully');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('owner.payments.index')->with('success', 'Payment deleted successfully');
    }
}
