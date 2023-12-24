<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        // panggil seeder DasasetSeeder
        $this->call(DasasetSeeder::class);
    }
}
