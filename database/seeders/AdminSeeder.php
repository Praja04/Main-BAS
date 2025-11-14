<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username'   => 'admin',
            'email'      => 'admin@example.com',
            'password'   => '12345678', // akan otomatis di-hash
            'jabatan'    => 'dept_head',
            'nik'        => '025000579',
            'departemen' => 'IT',
            'bagian'     => 'Backend',
            'image'      => 'default.png'
        ]);
    }

}
