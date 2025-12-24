<!DOCTYPE html>
<html>
<head>
    <title>Payment Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 15px;
            color: #6A67F3;
            text-decoration: none;
            font-weight: bold;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        .header h1 {
            font-size: 24px;
            color: #333;
        }
        .btn-add {
            background-color: #6A67F3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }
        .btn-add:hover {
            background-color: #6562f4;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stat-card h3 {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .stat-card .value {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .stat-card.danger .value {
            color: #cc0000;
        }
        .stat-card.success .value {
            color: #27ae60;
        }
        .section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 25px;
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        .section-header h2 {
            font-size: 18px;
            color: #333;
        }
        .overdue-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .overdue-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #fff5f5;
            border: 1px solid #ffcccc;
            border-radius: 4px;
        }
        .overdue-info h4 {
            font-size: 14px;
            color: #333;
            margin-bottom: 4px;
        }
        .overdue-info p {
            font-size: 12px;
            color: #666;
        }
        .overdue-badge {
            background: #cc0000;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }
        .filters {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .filters input,
        .filters select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 13px;
        }
        .filters input {
            flex: 1;
            min-width: 200px;
        }
        .payment-table {
            width: 100%;
            border-collapse: collapse;
        }
        .payment-table th {
            text-align: left;
            padding: 12px;
            background: #f9f9f9;
            color: #666;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            border-bottom: 2px solid #e0e0e0;
        }
        .payment-table td {
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 13px;
        }
        .payment-table tr:hover {
            background: #f9f9f9;
        }
        .status-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
        }
        .status-paid {
            background: #e8f5e9;
            color: #2e7d32;
        }
        .status-pending {
            background: #fff3e0;
            color: #f57c00;
        }
        .status-failed {
            background: #ffebee;
            color: #c62828;
        }
        .btn-edit {
            background: #6A67F3;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 11px;
            font-weight: bold;
        }
        .btn-edit:hover {
            background: #6562f4;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .modal.show {
            display: flex;
        }
        .modal-content {
            background-color: white;
            border-radius: 8px;
            width: 100%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #ddd;
            background-color: #f9f9f9;
        }
        .modal-header h2 {
            font-size: 18px;
            color: #333;
        }
        .modal-close {
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
            color: #999;
        }
        .modal-body {
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-size: 13px;
            font-weight: bold;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 13px;
            background-color: #f5f5f5;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .modal-buttons {
            display: flex;
            gap: 10px;
            padding: 20px;
            border-top: 1px solid #ddd;
            background-color: #f9f9f9;
        }
        .btn-cancel {
            flex: 1;
            padding: 10px;
            background-color: #e0e0e0;
            color: #333;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
        }
        .btn-submit {
            flex: 1;
            padding: 10px;
            background-color: #6A67F3;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
        }
        .btn-delete {
            flex: 1;
            padding: 10px;
            background-color: #cc0000;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
            display: none;
        }
        .btn-delete.show {
            display: block;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 20px;
        }
        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
        }
        .pagination .active {
            background: #6A67F3;
            color: white;
            border-color: #6A67F3;
        }
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            .payment-table {
                font-size: 11px;
            }
            .payment-table th,
            .payment-table td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('owner.dashboard') }}" class="back-link">← Back to Dashboard</a>

        <div class="header">
            <h1>Payment Management</h1>
            <button class="btn-add" onclick="openAddModal()">Record Payment</button>
        </div>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        {{-- Stats --}}
        <div class="stats-grid">
            <div class="stat-card success">
                <h3>Collected This Month</h3>
                <div class="value">Rp {{ number_format($totalCollected) }}</div>
            </div>
            <div class="stat-card danger">
                <h3>Overdue Payments</h3>
                <div class="value">{{ count($overdueTenants) }}</div>
            </div>
            <div class="stat-card">
                <h3>Total Payments</h3>
                <div class="value">{{ $payments->total() }}</div>
            </div>
        </div>

        {{-- Overdue Payments --}}
        @if(count($overdueTenants) > 0)
            <div class="section">
                <div class="section-header">
                    <h2>⚠️ Overdue Payments</h2>
                </div>
                <div class="overdue-list">
                    @foreach($overdueTenants as $overdue)
                        <div class="overdue-item">
                            <div class="overdue-info">
                                <h4>{{ $overdue['tenant']->name }} - Room {{ $overdue['tenant']->room->room_number }}</h4>
                                <p>Due: {{ $overdue['next_due_date']->format('M d, Y') }} | Amount: Rp {{ number_format($overdue['amount_due']) }}</p>
                            </div>
                            <div class="overdue-badge">{{ floor($overdue['days_overdue']) }} days late</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Payment History --}}
        <div class="section">
            <div class="section-header">
                <h2>Payment History</h2>
            </div>

            <div class="filters">
                <input type="text" id="searchInput" placeholder="Search by tenant or room" value="{{ request('search') }}">
                <select id="statusFilter">
                    <option value="">All Status</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
                <input type="month" id="monthFilter" value="{{ request('month') }}">
            </div>

            <table class="payment-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Tenant</th>
                        <th>Room</th>
                        <th>Period</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                            <td>{{ $payment->tenant->name }}</td>
                            <td>{{ $payment->tenant->room->room_number }}</td>
                            <td>{{ $payment->for_period }}</td>
                            <td>Rp {{ number_format($payment->amount) }}</td>
                            <td><span class="status-badge status-{{ $payment->status }}">{{ ucfirst($payment->status) }}</span></td>
                            <td>
                                <button class="btn-edit" onclick='editPayment(@json($payment))'>EDIT</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px; color: #999;">No payments found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $payments->links() }}
        </div>
    </div>

    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Record Payment</h2>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <form id="paymentForm" method="POST">
                @csrf
                <input type="hidden" id="formMethod" name="_method" value="POST">
                <div class="modal-body">
                    <input type="hidden" id="paymentId">

                    <div class="form-group">
                        <label>Tenant *</label>
                        <select name="tenant_id" id="tenant_id" required>
                            <option value="">Select Tenant</option>
                            @foreach($tenants as $tenant)
                                <option value="{{ $tenant->id }}">{{ $tenant->name }} - Room {{ $tenant->room->room_number }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Amount *</label>
                            <input type="number" name="amount" id="amount" min="0" required>
                        </div>
                        <div class="form-group">
                            <label>Payment Date *</label>
                            <input type="date" name="payment_date" id="payment_date" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Period *</label>
                            <input type="text" name="for_period" id="for_period" placeholder="e.g., December 2025" required>
                        </div>
                        <div class="form-group">
                            <label>Status *</label>
                            <select name="status" id="status" required>
                                <option value="paid">Paid</option>
                                <option value="pending">Pending</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-buttons">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-submit" id="submitBtn">Save</button>
                    <button type="button" class="btn-delete" id="deleteBtn" onclick="deletePayment()">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function applyFilters() {
            const search = document.getElementById('searchInput').value;
            const status = document.getElementById('statusFilter').value;
            const month = document.getElementById('monthFilter').value;
            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (status) params.append('status', status);
            if (month) params.append('month', month);
            window.location.href = '{{ route('owner.payments.index') }}?' + params.toString();
        }

        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') applyFilters();
        });
        document.getElementById('statusFilter').addEventListener('change', applyFilters);
        document.getElementById('monthFilter').addEventListener('change', applyFilters);

        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Record Payment';
            document.getElementById('paymentForm').action = '{{ route('owner.payments.store') }}';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('paymentForm').reset();
            document.getElementById('deleteBtn').classList.remove('show');
            document.getElementById('submitBtn').textContent = 'Save';
            document.getElementById('payment_date').value = new Date().toISOString().split('T')[0];
            document.getElementById('paymentModal').classList.add('show');
        }

        function editPayment(payment) {
            document.getElementById('modalTitle').textContent = 'Update Payment';
            document.getElementById('paymentForm').action = '/owner/payments/' + payment.id;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('paymentId').value = payment.id;
            document.getElementById('tenant_id').value = payment.tenant_id;
            document.getElementById('amount').value = payment.amount;
            document.getElementById('payment_date').value = payment.payment_date;
            document.getElementById('for_period').value = payment.for_period;
            document.getElementById('status').value = payment.status;
            document.getElementById('deleteBtn').classList.add('show');
            document.getElementById('submitBtn').textContent = 'Update';
            document.getElementById('paymentModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('paymentModal').classList.remove('show');
        }

        function deletePayment() {
            if (confirm('Are you sure you want to delete this payment record?')) {
                const id = document.getElementById('paymentId').value;
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/owner/payments/' + id;
                form.innerHTML = '@csrf <input type="hidden" name="_method" value="DELETE">';
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>
