<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        User::create([
            'name' => 'Admin AnakKost',
            'email' => 'admin@anak-kost.com',
            'password' => 'admin@anak-kost.com',
        ]);
    }
}
