<form method="POST" action="{{ route('tenant.store') }}" enctype="multipart/form-data" class="modal-content">
    @csrf

    <input type="hidden" name="room_id" id="room_id">

    <div class="modal-header">
        <h5 class="modal-title">Lengkapi Data Tenant</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
        {{-- Nama dari user (read-only) --}}
        @auth
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
        </div>
        @endauth

        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="phone_number" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tanggal Masuk</label>
            <input type="date" name="move_in_date" class="form-control" required min="{{ now()->toDateString() }}">
        </div>

        <div class="mb-3">
            <label>Foto KTP</label>
            <input type="file" name="ktp_photo" class="form-control" required>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">
            Simpan & Booking
        </button>
    </div>
</form>