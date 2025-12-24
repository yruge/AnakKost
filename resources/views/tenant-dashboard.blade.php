<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Dashboard - AnakKost</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="tenant-layout">
        <aside class="tenant-sidebar">
            <div class="tenant-sidebar-header">
                <h1>AnakKost</h1>
            </div>

            <nav class="tenant-sidebar-nav">
                <div class="tenant-nav-item">
                    <a href="{{ route('tenant.dashboard') }}" class="tenant-nav-link active">
                        <svg class="tenant-nav-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        Dashboard
                    </a>
                </div>
                <div class="tenant-nav-item">
                    <a href="{{ route('payments.index') }}" class="tenant-nav-link">
                        <svg class="tenant-nav-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        Payments
                    </a>
                </div>
            </nav>

            <div class="tenant-sidebar-footer">
                <div class="tenant-user-info">
                    <div class="tenant-user-details">
                        <span class="tenant-user-name">{{ auth()->user()->name }}</span>
                        <span class="tenant-user-room">Room {{ $tenant->room->room_number }}</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="tenant-logout-btn">Logout</button>
                </form>
            </div>
        </aside>

        <main class="tenant-main-content">
            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #c3e6cb;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #f5c6cb;">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('info'))
                <div style="background: #d1ecf1; color: #0c5460; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #bee5eb;">
                    {{ session('info') }}
                </div>
            @endif

            <div class="tenant-page-header">
                <h2 class="tenant-page-title">Hello, {{ auth()->user()->name }}</h2>
                <p class="tenant-page-subtitle">Room {{ $tenant->room->room_number }}</p>
            </div>

            <div class="tenant-card tenant-card-accent">
                <div class="tenant-card-header">
                    <span class="tenant-card-title">Payment</span>
                    <span class="tenant-price">Rp {{ number_format($tenant->room->price_per_month) }}</span>
                </div>

                <div>
                    <p class="tenant-info-label">Next payment</p>
                    <p class="tenant-info-value">{{ $nextPaymentDateFormatted }}</p>

                    <a href="{{ route('payments.index') }}" class="tenant-btn-primary">
                        Pay Now
                    </a>
                </div>
            </div>

            <div class="tenant-content-grid">
                <div class="tenant-card">
                    <h3 class="tenant-card-title">Room Information</h3>

                    <div class="tenant-info-grid">
                        <div class="tenant-info-item">
                            <p class="tenant-info-label">Room Number</p>
                            <p class="tenant-info-value">{{ $tenant->room->room_number }}</p>
                        </div>

                        <div class="tenant-info-item">
                            <p class="tenant-info-label">Date of Entry</p>
                            <p class="tenant-info-value">
                                {{ \Carbon\Carbon::parse($tenant->move_in_date)->translatedFormat('d F Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="tenant-card">
                    <h3 class="tenant-card-title">Emergency Contact</h3>

                    <div class="tenant-contact-item">
                        <span class="tenant-contact-label">Emergency Contact</span>
                        <a href="tel:081234567890" class="tenant-contact-link">0812-3456-7890</a>
                    </div>

                    <div class="tenant-contact-item">
                        <span class="tenant-contact-label">Security</span>
                        <a href="tel:081234567891" class="tenant-contact-link">0812-3456-7891</a>
                    </div>
                </div>
            </div>

            <div class="tenant-card">
                <h3 class="tenant-card-title">Boarding House Rules</h3>
                <ul class="tenant-rules">
                    <li>1. Rent payment is due monthly based on the tenant's move-in date</li>
                    <li>2. No overnight guests allowed</li>
                    <li>3. Keep the place clean</li>
                    <li>4. Turn off the lights when leaving</li>
                </ul>
            </div>
        </main>
    </div>
</body>
</html>
