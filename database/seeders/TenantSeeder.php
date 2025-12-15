<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $rooms = Room::where('status', 'available')->take(5)->get();

            foreach ($rooms as $room) {
                Tenant::factory()->create([
                    'room_id' => $room->id,
                ]);

                $room->update([
                    'status' => 'occupied',
                ]);
            }
        });
    }
}
