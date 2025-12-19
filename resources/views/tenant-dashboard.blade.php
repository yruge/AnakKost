@extends('navbar')

@section('content')
<div class="tenant-dashboard">

    {{-- HEADER --}}
    <div class="dashboard-header">
        <h1>Hello, {{ auth()->user()->name }}</h1>
        <p class="subtitle">
            Room {{ $tenant->room->room_number }}
        </p>
    </div>

    {{-- PAYMENT STATUS --}}
    <div class="card card-accent">
        <div class="card-header">
            <span>Payment</span>
            <span class="price">
                Rp {{ number_format($tenant->room->price_per_month) }}
            </span>
        </div>

        <div class="card-body">
            <p class="label">Next payment</p>
            <p class="value">{{ $nextPaymentDateFormatted }}</p>

            <a href="{{ route('payments.index') }}" class="btn-primary">
                Pay Now
            </a>
        </div>
    </div>

    {{-- ROOM INFO --}}
    <div class="card">
        <h3>Room Information</h3>

        <div class="info-grid">
            <div class="info-item">
                <p class="label">Room Number</p>
                <p class="value">{{ $tenant->room->room_number }}</p>
            </div>

            <div class="info-item">
                <p class="label">Date of Entry</p>
                <p class="value">
                    {{ \Carbon\Carbon::parse($tenant->move_in_date)->translatedFormat('d F Y') }}
                </p>
            </div>
        </div>
    </div>

    {{-- RULES --}}
    <div class="card">
        <h3>Boarding House Rules</h3>
        <ul class="rules">
            <li>1. Rent payment is due monthly based on the tenant’s move-in date</li>
            <li>2. No overnight guests allowed</li>
            <li>3. Keep the place clean</li>
            <li>4. Turn off the lights when leaving</li>
        </ul>
    </div>

    {{-- CONTACT --}}
    <div class="card">
        <h3>Kontak Darurat</h3>

        <div class="contact-item">
            <span>Emergency Contact</span>
            <a href="tel:081234567890">0812-3456-7890</a>
        </div>

        <div class="contact-item">
            <span>Security</span>
            <a href="tel:081234567891">0812-3456-7891</a>
        </div>
    </div>

</div>
@endsection
