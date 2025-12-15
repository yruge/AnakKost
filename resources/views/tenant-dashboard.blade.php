@extends('navbar')

@section('content')
<div class="tenant-dashboard">

    {{-- HEADER --}}
    <div class="dashboard-header">
        <h1>Halo, {{ auth()->user()->name }}</h1>
        <p class="subtitle">
            Kamar {{ $tenant->room->room_number }}
        </p>
    </div>

    {{-- PAYMENT STATUS --}}
    <div class="card card-accent">
        <div class="card-header">
            <span>Status Pembayaran</span>
            <span class="price">
                Rp {{ number_format($tenant->room->price_per_month) }}
            </span>
        </div>

        <div class="card-body">
            <p class="label">Pembayaran berikutnya</p>
            <p class="value">{{ $nextPaymentDate }}</p>

            <div class="progress">
                <div class="progress-bar" style="width: {{ $progress }}%"></div>
            </div>

            <a href="{{ route('payments.index') }}" class="btn-primary">
                Bayar Sekarang
            </a>
        </div>
    </div>

    {{-- ROOM INFO --}}
    <div class="card">
        <h3>Informasi Kamar</h3>

        <div class="info-grid">
            <div class="info-item">
                <p class="label">Nomor Kamar</p>
                <p class="value">{{ $tenant->room->room_number }}</p>
            </div>

            <div class="info-item">
                <p class="label">Tanggal Masuk</p>
                <p class="value">
                    {{ \Carbon\Carbon::parse($tenant->move_in_date)->translatedFormat('d F Y') }}
                </p>
            </div>
        </div>
    </div>

    {{-- RULES --}}
    <div class="card">
        <h3>Peraturan Kost</h3>
        <ul class="rules">
            <li>1. Pembayaran maksimal tanggal 5</li>
            <li>2. Dilarang membawa tamu menginap</li>
            <li>3. Jaga kebersihan bersama</li>
            <li>4. Matikan listrik saat keluar</li>
        </ul>
    </div>

    {{-- CONTACT --}}
    <div class="card">
        <h3>Kontak Darurat</h3>

        <div class="contact-item">
            <span>Pengelola Kost</span>
            <a href="tel:081234567890">0812-3456-7890</a>
        </div>

        <div class="contact-item">
            <span>Security</span>
            <a href="tel:081234567891">0812-3456-7891</a>
        </div>
    </div>

</div>
@endsection
