<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dataset;

class DasasetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dataset::factory()->create(
            [
                'nama' => 'Nur Chuzaifa',
                'umur' => '36',
                'lila' => '24',
                'tinggi' => '150',
                'bblr_nb' => false,
            ],
        );
        Dataset::factory()->create(
            [
                'nama' => 'Linda Cahyani',
                'umur' => '26',
                'lila' => '25.6',
                'tinggi' => '155',
                'bblr_nb' => false,
            ],
        );
        Dataset::factory()->create(
            [
                'nama' => 'Ella Yuni',
                'umur' => '24',
                'lila' => '24.5',
                'tinggi' => '150',
                'bblr_nb' => false,
            ],
        );
        Dataset::factory()->create(
            [
                'nama' => 'Sumarti',
                'umur' => '34',
                'lila' => '25',
                'tinggi' => '150',
                'bblr_nb' => false,
            ],
        );
        Dataset::factory()->create(
            [
                'nama' => 'Vidia',
                'umur' => '19',
                'lila' => '25.5',
                'tinggi' => '150',
                'bblr_nb' => true,
            ],
        );
        Dataset::factory()->create(
            [
                'nama' => 'Adelia',
                'umur' => '20',
                'lila' => '26.5',
                'tinggi' => '155',
                'bblr_nb' => true,
            ],
        );
        Dataset::factory()->create(
            [
                'nama' => 'Lasiana',
                'umur' => '38',
                'lila' => '33',
                'tinggi' => '155',
                'bblr_nb' => true,
            ],
        );
        Dataset::factory()->create(
            [
                'nama' => 'Kolipah',
                'umur' => '34',
                'lila' => '26',
                'tinggi' => '151',
                'bblr_nb' => true,
            ],
        );
        Dataset::factory()->create(
            [
                'nama' => 'Kusnaeni',
                'umur' => '33',
                'lila' => '27',
                'tinggi' => '150',
                'bblr_nb' => true,
            ],
        );
        Dataset::factory()->create(
            [
                'nama' => 'Nurul M.',
                'umur' => '27',
                'lila' => '24.5',
                'tinggi' => '155',
                'bblr_nb' => false,
            ],
        );
    }
}
