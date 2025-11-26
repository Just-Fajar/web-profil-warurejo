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
            'name' => 'desa Warurejo',
            'email' => 'desawarurejo@gmail.com',
            'password' => Hash::make('sholawatlah'),
            'phone' => '081234567890',
        ]);
    }
}