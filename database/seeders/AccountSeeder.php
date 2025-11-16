<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->withPersonalTeam()->create([
            'name' => 'Mis Unit',
            'email' => 'mis@siis.com',
            'position' => 'ISA I',
            'position_full' => 'Information Systems Analyst I',
            'office' => 'MIS',
            'office_full' => 'Management Information Systems',
            'role' => 'Superadmin',
            'dark_mode' => 'OFF',
            'password' => Hash::make('password'),
            'issuer_level' => 'NO',
            'supply_staff' => 'NO',
            'status' => 'ACTIVE',
        ]);
    }
}
