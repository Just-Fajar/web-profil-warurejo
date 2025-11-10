<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            ProfilDesaSeeder::class,
        ]);
        
        // Optional: Uncomment untuk seed data dummy
        // $this->call([
        //     BeritaSeeder::class,
        //     PotensiDesaSeeder::class,
        //     GaleriSeeder::class,
        // ]);
    }
}