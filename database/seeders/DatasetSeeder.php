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
    }
}
