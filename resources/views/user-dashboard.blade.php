@extends('navbar')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-12">
            @auth
                <div class="dashboard-header">
                    <h1 class="welcome-text">
                        Welcome, <strong>{{ auth()->user()->name }}</strong>
                    </h1>
                </div>
            @endauth

            @guest
                <p>Welcome! Please log in to make a booking.</p>
            @endguest
            <div class="card mb-4">
                <div class="card-body">
                    @if ($tenant && $tenant->room)
                        <strong>Status:</strong> Room already booked
                        <br>
                        <a href="{{ route('tenant.dashboard') }}" class="btn btn-primary mt-2">
                            See Room Dashboard
                        </a>
                    @else
                        <strong>Status:</strong> Not yet booked a room
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Room List</h4>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Room</th>
                                <th>Price / Month</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rooms as $room)
                            <tr>
                                <td>{{ $room->room_number }}</td>
                                <td>Rp {{ number_format($room->price_per_month) }}</td>

                                <td>
                                    @if ($room->status === 'available')
                                        <span class="badge bg-success">Available</span>
                                    @else
                                        <span class="badge bg-danger">Occupied</span>
                                    @endif
                                </td>

                                <td>
                                    {{-- USER BELUM LOGIN --}}
                                    @guest
                                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">
                                            Booking
                                        </a>
                                    @endguest
                                    {{-- USER SUDAH LOGIN --}}
                                    @auth
                                        @if ($room->status === 'available')
                                            @if (!$tenant)
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#tenantModal" data-room-id="{{ $room->id }}">
                                                    Book
                                                </button>

                                             @else
                                                 <button class="btn btn-sm btn-secondary" disabled>
                                                    Already Have a Room
                                                </button>
                                            @endif
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                Booked
                                            </button>
                                        @endif
                                    @endauth
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Tenant Modal -->
            <div class="modal fade" id="tenantModal" tabindex="-1">
                <div class="modal-dialog">
                    @auth
                        @include('register-tenant')
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('tenantModal');

    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const roomId = button.getAttribute('data-room-id');

        modal.querySelector('#room_id').value = roomId;
    });
});
</script>
@endpush