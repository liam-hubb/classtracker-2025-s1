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

uses(RefreshDatabase::class);

it('can delete a course', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $course = Course::factory()->create();

    $nationalCode = $course->national_code;
    $aqfLevel = $course->aqf_level;
    $title = $course->title;
    $tgaStatus = $course->tga_status;
    $stateCode = $course->state_code;
    $nominalHours = $course->nominal_hours;
    $type = $course->type;
    $qa = $course->qa;
    $natCode = $course->nat_code;
    $natTitle = $course->nat_title;
    $natCodeTitle = $course->nat_code_title;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->deleteJson(route('api.v1.courses.destroy', $course->id));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
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
            'message' => 'Course deleted',
            'data' => [
                'national_code' => $nationalCode,
                'aqf_level' => $aqfLevel,
                'title' => $title,
                'tga_status' => $tgaStatus,
                'state_code' => $stateCode,
                'nominal_hours' => $nominalHours,
                'type' => $type,
                'qa' => $qa,
                'nat_code' => $natCode,
                'nat_title' => $natTitle,
                'nat_code_title' => $natCodeTitle,
            ]
        ]);

    expect(Course::find($course->id))->toBeNull();
});

it('returns error when trying to delete a non-existent course', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $nonExistentId = 9999;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->deleteJson(route('api.v1.courses.destroy', $nonExistentId));

//    dd($response->json()); // Check the actual response content

    $response->assertStatus(404)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => []
        ])
        ->assertJson([
            'success' => false,
            'message' => 'Specific Course Not Found',
            'data' => []
        ]);
});
