<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Owner Dashboard - AnakKost</title>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1>AnakKost Admin</h1>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-item">
                    <a href="{{ route('owner.dashboard') }}" class="nav-link active">
                        <svg class="nav-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        Dashboard
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('owner.rooms.index') }}" class="nav-link">
                        <svg class="nav-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
                        </svg>
                        Rooms
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('owner.tenants.index') }}" class="nav-link">
                        <svg class="nav-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                        Tenants
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('owner.payments.index') }}" class="nav-link">
                        <svg class="nav-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        Payments
                    </a>
                </div>
            </nav>

            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-details">
                        <span class="user-name">Admin {{ auth()->user()->name }}</span>
                        <span class="user-role">AnakKost</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </aside>

        <main class="main-content">
            <div class="page-header">
                <h2 class="page-title">Dashboard</h2>
                <p class="page-subtitle">Welcome back, {{ auth()->user()->name }}</p>
            </div>

            <div class="kpi-grid">
                <div class="kpi-card">
                    <p class="kpi-label">Total Rooms</p>
                    <p class="kpi-value">{{ $totalRooms }}</p>
                </div>

                <div class="kpi-card">
                    <p class="kpi-label">Occupied</p>
                    <p class="kpi-value green">{{ $occupiedRooms }}</p>
                </div>

                <div class="kpi-card">
                    <p class="kpi-label">Available</p>
                    <p class="kpi-value blue">{{ $availableRooms }}</p>
                </div>

                <div class="kpi-card">
                    <p class="kpi-label">Total Tenants</p>
                    <p class="kpi-value">{{ $totalTenants }}</p>
                </div>

                <div class="kpi-card">
                    <p class="kpi-label">Monthly Revenue</p>
                    <p class="kpi-value green">Rp {{ number_format($monthlyRevenue) }}</p>
                </div>
            </div>

            <div class="content-grid">
                <div class="content-card">
                    <h3 class="card-title">Recent Tenants</h3>
                    
                    @if($recentTenants->count() > 0)
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Room</th>
                                    <th>Move-in Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTenants as $tenant)
                                    <tr>
                                        <td>{{ $tenant->name }}</td>
                                        <td>{{ $tenant->room->room_number }}</td>
                                        <td class="text-muted">
                                            {{ \Carbon\Carbon::parse($tenant->move_in_date)->format('M d, Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="empty-state">No tenants yet</p>
                    @endif
                </div>

                <div class="content-card">
                    <h3 class="card-title">Recent Payments</h3>
                    
                    @if($recentPayments->count() > 0)
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Tenant</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPayments as $payment)
                                    <tr>
                                        <td>{{ $payment->tenant->name }}</td>
                                        <td class="amount">
                                            Rp {{ number_format($payment->amount) }}
                                        </td>
                                        <td class="text-muted">
                                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="empty-state">No payments yet</p>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>