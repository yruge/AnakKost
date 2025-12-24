<!DOCTYPE html>
<html>
<head>
    <title>Room Admin</title>
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
        }
        .header {
            margin-bottom: 25px;
        }
        .header h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 5px;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 15px;
            color: #6A67F3;
            text-decoration: none;
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
        .rooms-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .room-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: box-shadow 0.3s;
        }
        .room-card:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .room-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .room-number {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-occupied {
            background-color: #AAC4F5;
            color: #6562f4;
        }
        .status-available {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        .room-info {
            margin-bottom: 15px;
        }
        .room-info p {
            color: #666;
            font-size: 13px;
            margin-bottom: 6px;
        }
        .room-info strong {
            color: #333;
        }
        .room-actions {
            display: flex;
            gap: 10px;
        }
        .btn-action {
            flex: 1;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 12px;
            transition: background-color 0.3s;
        }
        .btn-edit-action {
            background-color: #6A67F3;
            color: white;
        }
        .btn-edit-action:hover {
            background-color: #6562f4;
        }
        .btn-delete-action {
            background-color: #BF124D;
            color: white;
        }
        .btn-delete-action:hover {
            background-color: #990000;
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
        .btn-modal {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
            transition: background-color 0.3s;
        }
        .btn-cancel {
            background-color: #e0e0e0;
            color: #333;
        }
        .btn-cancel:hover {
            background-color: #d0d0d0;
        }
        .btn-update {
            background-color: #6A67F3;
            color: white;
        }
        .btn-update:hover {
            background-color: #6562f4;
        }
        .btn-modal-delete {
            background-color: #cc0000;
            color: white;
        }
        .btn-modal-delete:hover {
            background-color: #990000;
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
            .room-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            .room-actions {
                width: 100%;
            }
            .btn-action {
                flex: 1;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('owner.dashboard') }}" class="back-link">← Back to Dashboard</a>

        <div class="header">
            <h1>Manage Rooms</h1>
        </div>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <div class="filters">
            <input type="text" id="searchInput" placeholder="Search by room number" value="{{ request('search') }}">
            <select id="statusFilter">
                <option value="">All Status</option>
                <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
            </select>
            <button class="btn-add" onclick="openAddModal()">Add Room</button>
        </div>

        <div class="rooms-list" id="roomsList">
            @foreach($rooms as $room)
                <div class="room-card">
                    <div class="room-header">
                        <div class="room-number">Room {{ $room->room_number }}</div>
                        <span class="status-badge status-{{ $room->status }}">
                            {{ ucfirst($room->status) }}
                        </span>
                    </div>
                    <div class="room-info">
                        <p><strong>Size:</strong> {{ $room->size }}</p>
                        <p><strong>Price:</strong> Rp {{ number_format($room->price_per_month) }}/month</p>
                    </div>
                    <div class="room-actions">
                        <button class="btn-action btn-edit-action" onclick="editRoom({{ $room->id }}, '{{ $room->room_number }}', '{{ $room->size }}', {{ $room->price_per_month }}, '{{ $room->status }}')">EDIT</button>
                        <button class="btn-action btn-delete-action" onclick="deleteRoomDirect({{ $room->id }})">DELETE</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="editRoomModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Add Room</h2>
                <button class="modal-close" onclick="closeEditModal()">&times;</button>
            </div>
            <form id="roomForm" method="POST">
                @csrf
                <input type="hidden" id="formMethod" name="_method" value="POST">
                <div class="modal-body">
                    <input type="hidden" id="roomId">

                    <div class="form-row">
                        <div class="form-group">
                            <label>Room Number *</label>
                            <input type="text" name="room_number" id="roomNumber" required>
                        </div>
                        <div class="form-group">
                            <label>Size *</label>
                            <input type="text" name="size" id="roomSize" placeholder="e.g., 5x5m" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Price per Month *</label>
                            <input type="number" name="price_per_month" id="pricePerMonth" min="0" required>
                        </div>
                        <div class="form-group">
                            <label>Status *</label>
                            <select name="status" id="roomStatus" required>
                                <option value="available">Available</option>
                                <option value="occupied">Occupied</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-buttons">
                    <button type="button" class="btn-modal btn-cancel" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn-modal btn-update" id="submitBtn">Save</button>
                    <button type="button" class="btn-modal btn-modal-delete" id="deleteBtn" style="display: none;" onclick="deleteRoom()">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function applyFilters() {
            const search = document.getElementById('searchInput').value;
            const status = document.getElementById('statusFilter').value;
            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (status) params.append('status', status);
            window.location.href = '{{ route('owner.rooms.index') }}?' + params.toString();
        }

        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') applyFilters();
        });

        document.getElementById('statusFilter').addEventListener('change', applyFilters);

        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add Room';
            document.getElementById('roomForm').action = '{{ route('owner.rooms.store') }}';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('roomForm').reset();
            document.getElementById('deleteBtn').style.display = 'none';
            document.getElementById('submitBtn').textContent = 'Save';
            document.getElementById('editRoomModal').classList.add('show');
        }

        function editRoom(id, number, size, price, status) {
            document.getElementById('modalTitle').textContent = 'Update Room';
            document.getElementById('roomForm').action = '/owner/rooms/' + id;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('roomId').value = id;
            document.getElementById('roomNumber').value = number;
            document.getElementById('roomSize').value = size;
            document.getElementById('pricePerMonth').value = price;
            document.getElementById('roomStatus').value = status;
            document.getElementById('deleteBtn').style.display = 'block';
            document.getElementById('submitBtn').textContent = 'Update';
            document.getElementById('editRoomModal').classList.add('show');
        }

        function closeEditModal() {
            document.getElementById('editRoomModal').classList.remove('show');
        }

        function deleteRoom() {
            if (confirm('Are you sure you want to delete this room?')) {
                const id = document.getElementById('roomId').value;
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/owner/rooms/' + id;
                form.innerHTML = '@csrf <input type="hidden" name="_method" value="DELETE">';
                document.body.appendChild(form);
                form.submit();
            }
        }

        function deleteRoomDirect(id) {
            if (confirm('Are you sure you want to delete this room?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/owner/rooms/' + id;
                form.innerHTML = '@csrf <input type="hidden" name="_method" value="DELETE">';
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>
