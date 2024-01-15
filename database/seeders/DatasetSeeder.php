<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Dataset;

class DatasetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/datasets.csv"), "r");

        $firstLine = true;
        while (($data = fgetcsv($csvFile, 2000, ";")) !== FALSE) {
            // Skip the first line (header)
            if ($firstLine) {
                $firstLine = false;
                continue;
            }

            DB::table('datasets')->insert([
                "nama" => $data[0],
                "umur" => $data[1],
                "lila" => $data[2],
                "tinggi" => $data[3],
                "bblr" => $data[4],
            ]);
        }

        fclose($csvFile);

        // Dataset::factory()->create(
        //     [
        //         'nama' => 'Nur Chuzaifa',
        //         'umur' => '36',
        //         'lila' => '24',
        //         'tinggi' => '150',
        //         'bblr' => false,
        //     ],
        // );
        // Dataset::factory()->create(
        //     [
        //         'nama' => 'Linda Cahyani',
        //         'umur' => '26',
        //         'lila' => '25.6',
        //         'tinggi' => '155',
        //         'bblr' => false,
        //     ],
        // );
        // Dataset::factory()->create(
        //     [
        //         'nama' => 'Ella Yuni',
        //         'umur' => '24',
        //         'lila' => '24.5',
        //         'tinggi' => '150',
        //         'bblr' => false,
        //     ],
        // );
        // Dataset::factory()->create(
        //     [
        //         'nama' => 'Sumarti',
        //         'umur' => '34',
        //         'lila' => '25',
        //         'tinggi' => '150',
        //         'bblr' => false,
        //     ],
        // );
        // Dataset::factory()->create(
        //     [
        //         'nama' => 'Vidia',
        //         'umur' => '19',
        //         'lila' => '25.5',
        //         'tinggi' => '150',
        //         'bblr' => true,
        //     ],
        // );
        // Dataset::factory()->create(
        //     [
        //         'nama' => 'Adelia',
        //         'umur' => '20',
        //         'lila' => '26.5',
        //         'tinggi' => '155',
        //         'bblr' => true,
        //     ],
        // );
        // Dataset::factory()->create(
        //     [
        //         'nama' => 'Lasiana',
        //         'umur' => '38',
        //         'lila' => '33',
        //         'tinggi' => '155',
        //         'bblr' => true,
        //     ],
        // );
        // Dataset::factory()->create(
        //     [
        //         'nama' => 'Kolipah',
        //         'umur' => '34',
        //         'lila' => '26',
        //         'tinggi' => '151',
        //         'bblr' => true,
        //     ],
        // );
        // Dataset::factory()->create(
        //     [
        //         'nama' => 'Kusnaeni',
        //         'umur' => '33',
        //         'lila' => '27',
        //         'tinggi' => '150',
        //         'bblr' => true,
        //     ],
        // );
        // Dataset::factory()->create(
        //     [
        //         'nama' => 'Nurul M.',
        //         'umur' => '27',
        //         'lila' => '24.5',
        //         'tinggi' => '155',
        //         'bblr' => false,
        //     ],
        // );
    }
}
