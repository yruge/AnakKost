<!DOCTYPE html>
<html>
<head>
    <title>Tenant Admin - AnakKost</title>
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
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
        .loading {
            text-align: center;
            padding: 20px;
            color: #666;
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
        <div class="header">
            <div>
                <h1>Tenants</h1>
                <p>Manage tenant information</p>
            </div>
            <button class="btn-add" onclick="openAddModal()">Add Tenant</button>
        </div>

        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Search" onkeyup="renderTenants()">
        </div>

        <div class="tenants-list" id="tenantsList">
            <div class="loading">Loading tenants...</div>
        </div>
    </div>

    <div id="tenantModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Add Tenant</h2>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <form onsubmit="submitForm(event)">
                <div class="modal-body">
                    <div id="errorMessage" class="error-message" style="display: none;"></div>
                    
                    <input type="hidden" id="tenantId">

                    <div class="form-row">
                        <div class="form-group">
                            <label>Name *</label>
                            <input type="text" id="name" required>
                        </div>
                        <div class="form-group">
                            <label>ID Number *</label>
                            <input type="text" id="id_number" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Contact Number *</label>
                            <input type="tel" id="contact_number" required>
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" id="email" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Room *</label>
                            <select id="room_id" required>
                                <option value="">Select Room</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Move-in Date *</label>
                            <input type="date" id="move_in_date" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Move-out Date</label>
                        <input type="date" id="move_out_date">
                    </div>
                </div>

                <div class="modal-buttons">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-submit">Save</button>
                    <button type="button" class="btn-delete" id="deleteBtn" onclick="deleteTenant()">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let tenants = [];
        let rooms = [];
        const API_BASE = '/api';

        // Setup CSRF token for all requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        async function loadTenants() {
            try {
                const response = await fetch(`${API_BASE}/tenants`);
                const data = await response.json();
                if (data.status === 'success') {
                    tenants = data.data;
                    renderTenants();
                }
            } catch (error) {
                console.error('Error loading tenants:', error);
                document.getElementById('tenantsList').innerHTML = '<div class="loading">Error loading tenants</div>';
            }
        }

        async function loadRooms() {
            try {
                const response = await fetch(`${API_BASE}/rooms`);
                const data = await response.json();
                if (data.message === 'success') {
                    rooms = data.data;
                    populateRoomSelect();
                }
            } catch (error) {
                console.error('Error loading rooms:', error);
            }
        }

        function populateRoomSelect() {
            const select = document.getElementById('room_id');
            select.innerHTML = '<option value="">Select Room</option>';
            rooms.filter(r => r.status === 'available').forEach(room => {
                const option = document.createElement('option');
                option.value = room.id;
                option.textContent = `Room ${room.room_number}`;
                select.appendChild(option);
            });
        }

        function renderTenants() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const filtered = tenants.filter(t => 
                (t.name && t.name.toLowerCase().includes(searchTerm)) || 
                (t.contact_number && t.contact_number.includes(searchTerm)) ||
                (t.phone_number && t.phone_number.includes(searchTerm)) ||
                (t.id_number && t.id_number.includes(searchTerm))
            );

            const container = document.getElementById('tenantsList');
            if (filtered.length === 0) {
                container.innerHTML = '<div class="loading">No tenants found</div>';
                return;
            }

            container.innerHTML = filtered.map(tenant => `
                <div class="tenant-card">
                    <div class="tenant-info">
                        <h3>${tenant.name || 'N/A'}</h3>
                        <p>${tenant.id_number || 'No ID'}</p>
                        <p>${tenant.contact_number || tenant.phone_number || 'No contact'}</p>
                        <p>${tenant.email || 'No email'}</p>
                        <p>Room: ${tenant.room_id || 'N/A'}</p>
                    </div>
                    <button class="btn-edit" onclick="editTenant(${tenant.id})">EDIT</button>
                </div>
            `).join('');
        }

        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add Tenant';
            document.getElementById('tenantId').value = '';
            document.getElementById('deleteBtn').classList.remove('show');
            document.getElementById('errorMessage').style.display = 'none';
            document.getElementById('tenantModal').classList.add('show');
            document.querySelector('form').reset();
            loadRooms();
        }

        async function editTenant(id) {
            const tenant = tenants.find(t => t.id === id);
            if (!tenant) return;

            await loadRooms();

            document.getElementById('modalTitle').textContent = 'Update Tenant';
            document.getElementById('tenantId').value = tenant.id;
            document.getElementById('name').value = tenant.name || '';
            document.getElementById('id_number').value = tenant.id_number || '';
            document.getElementById('contact_number').value = tenant.contact_number || tenant.phone_number || '';
            document.getElementById('email').value = tenant.email || '';
            document.getElementById('room_id').value = tenant.room_id || '';
            document.getElementById('move_in_date').value = tenant.move_in_date || '';
            document.getElementById('move_out_date').value = tenant.move_out_date || '';
            
            document.getElementById('deleteBtn').classList.add('show');
            document.getElementById('errorMessage').style.display = 'none';
            document.getElementById('tenantModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('tenantModal').classList.remove('show');
        }

        async function submitForm(event) {
            event.preventDefault();
            const id = document.getElementById('tenantId').value;
            const formData = {
                name: document.getElementById('name').value,
                id_number: document.getElementById('id_number').value,
                phone_number: document.getElementById('contact_number').value,
                contact_number: document.getElementById('contact_number').value,
                email: document.getElementById('email').value,
                room_id: document.getElementById('room_id').value,
                move_in_date: document.getElementById('move_in_date').value,
                move_out_date: document.getElementById('move_out_date').value,
            };

            try {
                let response;
                if (id) {
                    // Update existing tenant
                    response = await fetch(`${API_BASE}/tenants/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(formData)
                    });
                } else {
                    // Create new tenant
                    response = await fetch(`${API_BASE}/tenants`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(formData)
                    });
                }

                const data = await response.json();
                
                if (response.ok) {
                    closeModal();
                    loadTenants();
                } else {
                    const errorMsg = document.getElementById('errorMessage');
                    errorMsg.textContent = data.message || 'Error saving tenant';
                    errorMsg.style.display = 'block';
                }
            } catch (error) {
                console.error('Error saving tenant:', error);
                const errorMsg = document.getElementById('errorMessage');
                errorMsg.textContent = 'Network error. Please try again.';
                errorMsg.style.display = 'block';
            }
        }

        async function deleteTenant() {
            if (!confirm('Are you sure you want to delete this tenant?')) return;

            const id = document.getElementById('tenantId').value;
            
            try {
                const response = await fetch(`${API_BASE}/tenants/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (response.ok) {
                    closeModal();
                    loadTenants();
                } else {
                    alert('Error deleting tenant');
                }
            } catch (error) {
                console.error('Error deleting tenant:', error);
                alert('Network error. Please try again.');
            }
        }

        // Initialize
        loadTenants();
        loadRooms();
    </script>
</body>
</html>
