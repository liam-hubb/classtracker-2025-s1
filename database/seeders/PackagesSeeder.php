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

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seedData = [
            [
                "national_code" => "BSB",
                "title" => "Business Services Training Package",
                "tga_status" => "current",
//                'course_id' => "BSB30715"
            ],
            [
                "national_code" => "CUA",
                "title" => "Creative Arts and Culture Training Package",
                "tga_status" => "current",
//                'course_id' => "BSB30715"

            ],
            [
                "national_code" => "FNS",
                "title" => "Financial Services Training Package",
                "tga_status" => "current",
//                'course_id' => "BSB30715"

            ],
            [
                "national_code" => 'ICT',
                "title" => "Information and Communications Technology",
                "tga_status" => "current",
//                'course_id' => "BSB30715"

            ],
            ];

        $this->command->getOutput()->info("Shuffling Package");
        shuffle($seedData);
        $this->command->getOutput()->info("Shuffling Complete");

        $numRecords = count($seedData);
        $this->command->getOutput()->progressStart($numRecords);

        foreach ($seedData as $newPackage) {
            Package::create($newPackage);
            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();

    }
}
