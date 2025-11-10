<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'Admin Desa Warurejo',
            'email' => 'adminwarurejo@gmail.com',
            'password' => Hash::make('admin123'),
            'phone' => '081234567890',
        ]);
    }
}