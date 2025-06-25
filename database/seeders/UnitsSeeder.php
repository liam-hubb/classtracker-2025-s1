<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/units.csv"), "r");

        $firstLine = true;
        while (($data = fgetcsv($csvFile, 1000, ",")) !== FALSE) {
            if (!$firstLine) {
                $national_code = trim($data[0]);
                $title = trim(preg_replace('/[\x00-\x1F\x7F\xA0]/u', ' ', $data[1]));
                $tga_status = trim($data[2]);
                $state_code = trim($data[3]);
                $nominal_hours = trim($data[4]);

                DB::table('units')->insert([
                    "national_code" => $national_code,
                    "title" => $title,
                    "tga_status" => $tga_status,
                    "state_code" => $state_code,
                    "nominal_hours" => $nominal_hours,
//                    'cluster_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $firstLine = false;
        }

        fclose($csvFile);
    }
}
