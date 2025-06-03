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

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

// Necessary to access Laravel testing helpers and database factory stuff
uses(
    RefreshDatabase::class
);


test('course exists and is returned correctly', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $course = Course::factory()->create();

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->getJson(route('api.v1.courses.show', $course->id)); // call '/api/v1/courses'


    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' =>
                [
                    'id',
                    'national_code',
                    'aqf_level',
                    'title',
                    'tga_status',
                    'state_code',
                    'nominal_hours',
                    'type',
                    'qa',
                    'nat_code',
                    'nat_title',
                    'nat_code_title',
                    'created_at',
                    'updated_at'
                ]
        ])

        ->assertJson([
            'success' => true,
            'message' => 'Specific Course Found',
            'data' => [
                'id' => $course->id,
                'national_code'=> $course->national_code,
                'aqf_level'=> $course->aqf_level,
                'title'=> $course->title,
                'tga_status'=> $course->tga_status,
                'state_code'=> $course->state_code,
                'nominal_hours' => (string) $course->nominal_hours,
                'type'=> $course->type,
                'qa'=> $course->qa,
                'nat_code'=> $course->nat_code,
                'nat_title'=> $course->nat_title,
                'nat_code_title'=> $course->nat_code_title
            ]
        ]);
});

test('course does not exist and returns 404', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $nonExistentCourseId = 999;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->getJson(route('api.v1.courses.show', $nonExistentCourseId)); // call '/api/v1/courses'

    $response->assertStatus(404)
        ->assertJson([
            'success' => false,
            'message' => 'Specific Course Not Found',
            'data' => []
        ]);
});
