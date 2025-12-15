<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Room;
use App\Models\Tenant;

class SyncRoomStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rooms:sync-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync room status based on tenant occupancy';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Syncing room statuses...');

        // Get all rooms
        $rooms = Room::all();
        $updated = 0;

        foreach ($rooms as $room) {
            // Check if room has a tenant
            $hasTenant = Tenant::where('room_id', $room->id)->exists();
            
            $newStatus = $hasTenant ? 'occupied' : 'available';
            
            if ($room->status !== $newStatus) {
                $room->update(['status' => $newStatus]);
                $this->line("Room {$room->room_number}: {$room->status} -> {$newStatus}");
                $updated++;
            }
        }

        $this->info("Sync complete! Updated {$updated} room(s).");
        return 0;
    }
}
