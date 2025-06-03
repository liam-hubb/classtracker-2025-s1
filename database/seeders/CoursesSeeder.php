<?php
/**
 * Assessment Title: Portfolio Part 1
 * Cluster:          SaaS - BED: APIs & NoSQL - 2025 S1
 * Qualification:    ICT50220 (Advanced Programming)
 * Name:             Yui Migaki
 * Student ID:       20098757
 * Year/Semester:    2025/S1
 *
 * YOUR SUMMARY OF PORTFOLIO ACTIVITY
 * This portfolio work was conducted within a team called classTracker with 4 people.
 * I contributed by adding features for courses and packages as well as APIs for those features.
 * This project includes implementing a REST API and a management interface to create a new “Student Tracking” system.
 */

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/courses.csv"), "r");

        $line = true;
        while (($data = fgetcsv($csvFile, 1000, ",")) !== FALSE) {
            if (!$line) {
                DB::table('courses')->insert([
                    "national_code" => $data[0],
                    "aqf_level" => $data[1],
                    "title" => $data[2],
                    "tga_status" => $data[3],
                    "state_code" => $data[4],
                    "nominal_hours" => $data[5],
                    "type" => $data[6],
                    "qa" => $data[7],
                    "nat_code" => $data[8],
                    "nat_title" => $data[9],
                    "nat_code_title" => $data[10],
                ]);
            }
            $line = false;
        }

        // Give a random id to some courses so we don't manually have to do it everytime we do a migration
        for ($i = 1; $i <= 10; $i++) {
            DB::table('courses')->where('id', $i)->update(['package_id' => rand(1,4)]);
        }

        fclose($csvFile);
    }
}
