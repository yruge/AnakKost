<!DOCTYPE html>
<html>
<head>
    <title>Tenant Admin</title>
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
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        .header h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            font-size: 14px;
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
        .search-box {
            margin-bottom: 20px;
        }
        .search-box input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .tenants-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .tenant-card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: box-shadow 0.3s;
        }
        .tenant-card:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .tenant-info h3 {
            color: #333;
            font-size: 16px;
            margin-bottom: 8px;
        }
        .tenant-info p {
            color: #666;
            font-size: 13px;
            margin-bottom: 4px;
        }
        .btn-edit {
            background-color: #6A67F3;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
        }
        .btn-edit:hover {
            background-color: #6562f4;
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
        .form-group input, .form-group select {
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
        .btn-cancel:hover {
            background-color: #d0d0d0;
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
        .btn-submit:hover {
            background-color: #6562f4;
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
        .btn-delete:hover {
            background-color: #990000;
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
        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            .tenant-card {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('owner.dashboard') }}" class="back-link">← Back to Dashboard</a>

        <div class="header">
            <div>
                <h1>Tenants</h1>
                <p>Manage tenant information</p>
            </div>
            @unless(auth()->check() && auth()->user()->email === 'admin@anak-kost.com')
                <button class="btn-add" onclick="openAddModal()">Add Tenant</button>
            @endunless
        </div>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="success-message" style="background-color:#f8d7da;color:#721c24;border-color:#f5c6cb;">
                {{ session('error') }}
            </div>
        @endif

        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Search by name, phone, or email" value="{{ request('search') }}">
        </div>

        <div class="tenants-list" id="tenantsList">
            @foreach($tenants as $tenant)
                <div class="tenant-card">
                    <div class="tenant-info">
                        <h3>{{ $tenant->name }}</h3>
                        <p>{{ $tenant->user->email }}</p>
                        <p>{{ $tenant->phone_number }}</p>
                        <p>Room: {{ $tenant->room->room_number }}</p>
                    </div>
                    <button class="btn-edit" onclick='editTenant(@json($tenant))'>EDIT</button>
                </div>
            @endforeach
        </div>
    </div>

    <div id="tenantModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Add Tenant</h2>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <form id="tenantForm" method="POST">
                @csrf
                <input type="hidden" id="formMethod" name="_method" value="POST">
                <div class="modal-body">
                    <input type="hidden" id="tenantId">

                    <div class="form-row">
                        <div class="form-group">
                            <label>Name *</label>
                            <input type="text" name="name" id="name" required>
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" name="email" id="email" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Contact Number *</label>
                            <input type="tel" name="phone_number" id="contact_number" required>
                        </div>
                        <div class="form-group">
                            <label>Room *</label>
                            <select name="room_id" id="room_id" required>
                                <option value="">Select Room</option>
                                @foreach($availableRooms as $room)
                                    <option value="{{ $room->id }}">Room {{ $room->room_number }} - Rp {{ number_format($room->price_per_month) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Move-in Date *</label>
                        <input type="date" name="move_in_date" id="move_in_date" required>
                    </div>
                </div>

                <div class="modal-buttons">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-submit" id="submitBtn">Save</button>
                    <button type="button" class="btn-delete" id="deleteBtn" onclick="deleteTenant()">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                const search = this.value;
                const params = new URLSearchParams();
                if (search) params.append('search', search);
                window.location.href = '{{ route('owner.tenants.index') }}?' + params.toString();
            }
        });

        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add Tenant';
            document.getElementById('tenantForm').action = '{{ route('owner.tenants.store') }}';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('tenantForm').reset();
            document.getElementById('deleteBtn').classList.remove('show');
            document.getElementById('submitBtn').textContent = 'Save';
            document.getElementById('tenantModal').classList.add('show');
        }

        function editTenant(tenant) {
            document.getElementById('modalTitle').textContent = 'Update Tenant';
            document.getElementById('tenantForm').action = '/owner/tenants/' + tenant.id;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('tenantId').value = tenant.id;
            document.getElementById('name').value = tenant.name;
            document.getElementById('email').value = tenant.user.email;
            document.getElementById('contact_number').value = tenant.phone_number;
            document.getElementById('move_in_date').value = tenant.move_in_date;
            
            // Add current room to dropdown if not already there
            const roomSelect = document.getElementById('room_id');
            let roomExists = false;
            for (let option of roomSelect.options) {
                if (option.value == tenant.room_id) {
                    roomExists = true;
                    option.selected = true;
                    break;
                }
            }
            if (!roomExists) {
                const option = document.createElement('option');
                option.value = tenant.room_id;
                option.text = 'Room ' + tenant.room.room_number + ' (Current)';
                option.selected = true;
                roomSelect.add(option, 0);
            }
            
            document.getElementById('deleteBtn').classList.add('show');
            document.getElementById('submitBtn').textContent = 'Update';
            document.getElementById('tenantModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('tenantModal').classList.remove('show');
        }

        function deleteTenant() {
            if (confirm('Are you sure you want to delete this tenant? This will also delete their user account.')) {
                const id = document.getElementById('tenantId').value;
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/owner/tenants/' + id;
                form.innerHTML = '@csrf <input type="hidden" name="_method" value="DELETE">';
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>
