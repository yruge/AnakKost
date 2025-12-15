<?php

namespace Database\Seeders;
use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $tenants = Tenant::factory(5)->create();
        
        // Update room status to occupied for each tenant
        foreach ($tenants as $tenant) {
            if ($tenant->room_id) {
                Room::where('id', $tenant->room_id)->update(['status' => 'occupied']);
            }
        }
    }
}
