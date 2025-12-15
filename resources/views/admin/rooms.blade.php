<!DOCTYPE html>
<html>
<head>
    <title>Room Admin - AnakKost</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 5px;
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
        .form-group input {
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
        .loading {
            text-align: center;
            padding: 20px;
            color: #666;
            background-color: white;
            border-radius: 4px;
        }
        .error-message {
            background-color: #fee;
            border: 1px solid #fcc;
            color: #c00;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
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
        <div class="header">
            <h1>Manage Rooms & Bookings</h1>
        </div>

        <div class="filters">
            <input type="text" id="searchInput" placeholder="Search by room number or tenant name" onkeyup="renderRooms()">
            <select id="statusFilter" onchange="renderRooms()">
                <option value="">All Status</option>
                <option value="occupied">Occupied</option>
                <option value="available">Available</option>
            </select>
        </div>

        <div class="rooms-list" id="roomsList">
            <div class="loading">Loading rooms...</div>
        </div>
    </div>

    <div id="editRoomModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>View Room Details</h2>
                <button class="modal-close" onclick="closeEditModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div id="errorMessage" class="error-message" style="display: none;"></div>
                
                <input type="hidden" id="roomId">

                <div class="form-row">
                    <div class="form-group">
                        <label>Room Number</label>
                        <input type="text" id="roomNumber" readonly>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" id="roomStatus" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Size</label>
                        <input type="text" id="roomSize" readonly>
                    </div>
                    <div class="form-group">
                        <label>Price per Month</label>
                        <input type="text" id="roomPrice" readonly>
                    </div>
                </div>

                <div id="tenantInfo" style="display: none; margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd;">
                    <h3 style="margin-bottom: 15px; color: #333;">Tenant Information</h3>
                    <div class="form-group">
                        <label>Tenant Name</label>
                        <input type="text" id="tenantName" readonly>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Contact</label>
                            <input type="text" id="tenantContact" readonly>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" id="tenantEmail" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Move-in Date</label>
                            <input type="text" id="moveInDate" readonly>
                        </div>
                        <div class="form-group">
                            <label>Move-out Date</label>
                            <input type="text" id="moveOutDate" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-buttons">
                <button type="button" class="btn-modal btn-cancel" onclick="closeEditModal()">Close</button>
            </div>
        </div>
    </div>

    <script>
        // Version: 2.0 - Fixed status display
        console.log('Room script loaded - Version 2.0');
        let rooms = [];
        let tenants = [];
        const API_BASE = '/api';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        async function loadRooms() {
            try {
                const response = await fetch(`${API_BASE}/rooms?t=${Date.now()}`);
                const data = await response.json();
                console.log('Rooms API Response:', data);
                if (data.message === 'success') {
                    rooms = data.data;
                    await loadTenants();
                    renderRooms();
                }
            } catch (error) {
                console.error('Error loading rooms:', error);
                document.getElementById('roomsList').innerHTML = '<div class="loading">Error loading rooms</div>';
            }
        }

        async function loadTenants() {
            try {
                const response = await fetch(`${API_BASE}/tenants`);
                const data = await response.json();
                console.log('Tenants API Response:', data);
                if (data.status === 'success') {
                    tenants = data.data;
                }
            } catch (error) {
                console.error('Error loading tenants:', error);
            }
        }

        function getTenantByRoomId(roomId) {
            return tenants.find(t => t.room_id === roomId);
        }

        function renderRooms() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const status = document.getElementById('statusFilter').value;

            let filtered = rooms.filter(r => {
                const tenant = getTenantByRoomId(r.id);
                const actualStatus = tenant ? 'occupied' : 'available';
                
                const matchesSearch = r.room_number.toLowerCase().includes(searchTerm) || 
                                     (tenant && tenant.name.toLowerCase().includes(searchTerm));
                const matchesStatus = !status || actualStatus === status;
                return matchesSearch && matchesStatus;
            });

            const container = document.getElementById('roomsList');
            
            if (filtered.length === 0) {
                container.innerHTML = '<div class="loading">No rooms found</div>';
                return;
            }

            container.innerHTML = filtered.map(room => {
                const tenant = getTenantByRoomId(room.id);
                // Determine actual status based on tenant existence
                const actualStatus = tenant ? 'occupied' : 'available';
                
                return `
                    <div class="room-card">
                        <div class="room-header">
                            <div class="room-number">Room ${room.room_number}</div>
                            <span class="status-badge status-${actualStatus}">
                                ${actualStatus.charAt(0).toUpperCase() + actualStatus.slice(1)}
                            </span>
                        </div>
                        <div class="room-info">
                            ${tenant ? `
                                <p><strong>${tenant.name}</strong></p>
                                <p>${tenant.contact_number || tenant.phone_number || 'No contact'}</p>
                                <p>Check-in: ${tenant.move_in_date || 'N/A'}</p>
                            ` : `
                                <p>Size: ${room.size}</p>
                                <p>Price: Rp ${room.price_per_month ? room.price_per_month.toLocaleString() : 'N/A'}/month</p>
                            `}
                        </div>
                        <div class="room-actions">
                            <button class="btn-action btn-edit-action" onclick="viewRoom(${room.id})">VIEW DETAILS</button>
                        </div>
                    </div>
                `;
            }).join('');
        }

        async function viewRoom(id) {
            const room = rooms.find(r => r.id === id);
            if (!room) return;

            const tenant = getTenantByRoomId(room.id);

            document.getElementById('roomId').value = room.id;
            document.getElementById('roomNumber').value = room.room_number;
            document.getElementById('roomStatus').value = room.status.charAt(0).toUpperCase() + room.status.slice(1);
            document.getElementById('roomSize').value = room.size || 'N/A';
            document.getElementById('roomPrice').value = room.price_per_month ? `Rp ${room.price_per_month.toLocaleString()}` : 'N/A';
            
            const tenantInfoDiv = document.getElementById('tenantInfo');
            if (tenant) {
                document.getElementById('tenantName').value = tenant.name || 'N/A';
                document.getElementById('tenantContact').value = tenant.contact_number || tenant.phone_number || 'N/A';
                document.getElementById('tenantEmail').value = tenant.email || 'N/A';
                document.getElementById('moveInDate').value = tenant.move_in_date || 'N/A';
                document.getElementById('moveOutDate').value = tenant.move_out_date || 'N/A';
                tenantInfoDiv.style.display = 'block';
            } else {
                tenantInfoDiv.style.display = 'none';
            }
            
            document.getElementById('errorMessage').style.display = 'none';
            document.getElementById('editRoomModal').classList.add('show');
        }

        function closeEditModal() {
            document.getElementById('editRoomModal').classList.remove('show');
        }

        // Initialize
        loadRooms();
    </script>
</body>
</html>
