<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClustersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/clusters.csv"), "r");

        $line = true;
        while (($data = fgetcsv($csvFile, 1000, ",")) !== FALSE) {
            if (!$line) {
                DB::table('clusters')->insert([
                    "code" => $data[0],
                    "title" => $data[1],
                    "qualification" => $data[2],
                    "qualification_code" => $data[3],
                    "unit_1" => $data[4],
                    "unit_2" => $data[5],
                    "unit_3" => $data[6],
                    "unit_4" => $data[7],
                ]);
            }
            $line = false;
        }

        fclose($csvFile);
    }
}
