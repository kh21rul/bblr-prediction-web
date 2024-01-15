<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Datauji;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'Anindya Hilmi',
            'username' => 'anindyahilmi',
            'password' => bcrypt('anindya123'),
        ]);

        // Datauji::factory(30)->create();

        // panggil seeder DasasetSeeder
        $this->call(DatasetSeeder::class);
    }
}
