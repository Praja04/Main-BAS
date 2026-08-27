<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ImsUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Requestor (IT Staff)
        User::updateOrCreate(
            ['username' => 'staff_it'],
            [
                'password' => Hash::make('password123'),
                'jabatan' => 'supervisor', // Enum
                'departemen' => 'IT',
                'bagian' => 'Software',
            ]
        );

        // 2. Akun Manager IT
        User::updateOrCreate(
            ['username' => 'manager_it'],
            [
                'password' => Hash::make('password123'),
                'jabatan' => 'dept_head', // Enum for manager
                'departemen' => 'IT',
                'bagian' => 'Head',
            ]
        );

        // 3. Akun IMS (DC Center)
        User::updateOrCreate(
            ['username' => 'admin_ims'],
            [
                'password' => Hash::make('password123'),
                'jabatan' => 'dept_head',
                'departemen' => 'IMS',
                'bagian' => 'DC Center',
            ]
        );
    }
}
