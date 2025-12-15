<?php
namespace App\Http\Controllers;

use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $tenant = auth()->user()->tenant;
        $payments = Payment::where('tenant_id', $tenant->id)->get();

        return view('payments', compact('payments'));
    }
}
