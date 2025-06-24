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

test('update an existing course with new details (national_code, aqf_level, title, tga_status, state_code, nominal_hours and type)', function () {
    $this->withoutExceptionHandling();

    $user = User::factory()->create();
    $this->actingAs($user);

    $token = $user->createToken('TestToken')->plainTextToken;

    $course = Course::factory()->create();

    $updatedData = Course::factory()->make([
        'national_code' => 'NEW12345',
        'aqf_level' => 'Diploma of',
        'title' => 'Updated Course Title',
        'tga_status' => 'Current',
        'state_code' => 'VIC0',
        'nominal_hours' => 300,
        'type' => 'Qualification',

        // Optional fields can be null
        'qa' => null,
        'nat_code' => null,
        'nat_title' => null,
        'nat_code_title' => null,
    ])->toArray();


    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->putJson(route('api.v1.courses.update', $course->id), $updatedData); // call '/api/v1/courses'


    $response
        ->assertStatus(200)

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
                'created_at',
                'updated_at'
            ]
        ])

        ->assertJson([
            'success' => true,
            'message' => 'Course updated',
            'data' => [
                'id' => $course->id,
                'national_code'=> $updatedData['national_code'],
                'aqf_level'=> $updatedData['aqf_level'],
                'title' => $updatedData['title'],
                'tga_status' => $updatedData['tga_status'],
                'state_code' => $updatedData['state_code'],
                'nominal_hours' => $updatedData['nominal_hours'],
                'type' => $updatedData['type'],
            ]
        ]);

    $this->assertDatabaseHas('courses', [
        'id' => $course->id,
        'national_code' => $updatedData['national_code'],
        'aqf_level' => $updatedData['aqf_level'],
        'title' => $updatedData['title'],
        'tga_status' => $updatedData['tga_status'],
        'state_code' => $updatedData['state_code'],
        'nominal_hours' => $updatedData['nominal_hours'],
        'type' => $updatedData['type'],
    ]);
});


test('update an existing course with new details (national_code only)', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $course = Course::factory()->create();

    $updatedData = Course::factory()->make([
        'national_code' => 'AAA00000',
        'aqf_level' => $course->aqf_level,
        'title' => $course->title,
        'tga_status' => $course->tga_status,
        'state_code' => $course->state_code,
        'nominal_hours' => $course->nominal_hours,
        'type' => $course->type,

        // Optional fields can be null
        'qa' => null,
        'nat_code' => null,
        'nat_title' => null,
        'nat_code_title' => null,
    ])->toArray();

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->putJson(route('api.v1.courses.update', $course->id), $updatedData); // call '/api/v1/courses'

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => ['id', 'national_code', 'created_at', 'updated_at']
        ])

        ->assertJson([
            'success' => true,
            'message' => 'Course updated',
            'data' => [
                'id' => $course->id,
                'national_code' => $updatedData['national_code'],
            ]
        ]);


    $this->assertDatabaseHas('courses', [
        'id' => $course->id,
        'national_code' => $updatedData['national_code'],
        'aqf_level' => $course->aqf_level,
        'title' => $course->title,
        'tga_status' => $course->tga_status,
        'state_code' => $course->state_code,
        'nominal_hours' => $course->nominal_hours,
        'type' => $course->type,
    ]);
});

test('update an existing course with missing national_code', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $course = Course::factory()->create();
    $updatedData = [
        'aqf_level' => 'Diploma of',
        'title' => 'Updated Course Title',
        'tga_status' => 'Current',
        'state_code' => 'VIC7',
        'nominal_hours' => 300,
        'type' => 'Qualification',

        // Optional fields can be null
        'qa' => null,
        'nat_code' => null,
        'nat_title' => null,
        'nat_code_title' => null,
    ];

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->putJson(route('api.v1.courses.update', $course->id), $updatedData); // call '/api/v1/courses'

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['national_code']);
});
