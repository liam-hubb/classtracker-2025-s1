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
use App\Models\Package;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

// Necessary to access Laravel testing helpers and database factory stuff
uses(
    RefreshDatabase::class
);

test('update an existing package with new details (national_code, title, and tga_status)', function () {
    $this->withoutExceptionHandling();

    $user = User::factory()->create();
    $this->actingAs($user);

    $token = $user->createToken('TestToken')->plainTextToken;

    $package = Package::factory()->create();

    $updatedData = Package::factory()->make([
        'national_code' => 'JGU',
        'title' => 'Updated Package Title',
        'tga_status' => 'Current',
        // Optional fields can be null
        'course_id' => null,

    ])->toArray();


    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->putJson(route('api.v1.packages.update', $package->id), $updatedData); // call '/api/v1/packages'


    $response
        ->assertStatus(200)

        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'national_code',
                'title',
                'tga_status',
                'created_at',
                'updated_at'
            ]
        ])

        ->assertJson([
            'success' => true,
            'message' => 'Package Updated',
            'data' => [
                'id' => $package->id,
                'national_code'=> $updatedData['national_code'],
                'title' => $updatedData['title'],
                'tga_status' => $updatedData['tga_status'],
            ]
        ]);

    $this->assertDatabaseHas('packages', [
        'id' => $package->id,
        'national_code' => $updatedData['national_code'],
        'title' => $updatedData['title'],
        'tga_status' => $updatedData['tga_status'],
    ]);
});


test('update an existing package with new details (national_code only)', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $package = Package::factory()->create();

    $updatedData = Package::factory()->make([
        'national_code' => 'AAA',
        'title' => $package->title,
        'tga_status' => $package->tga_status,

        // Optional fields can be null
        'course_id' => null,
    ])->toArray();

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->putJson(route('api.v1.packages.update', $package->id), $updatedData); // call '/api/v1/packages'

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => ['id', 'national_code', 'created_at', 'updated_at']
        ])

        ->assertJson([
            'success' => true,
            'message' => 'Package Updated',
            'data' => [
                'id' => $package->id,
                'national_code' => $updatedData['national_code'],
            ]
        ]);


    $this->assertDatabaseHas('packages', [
        'id' => $package->id,
        'national_code' => $updatedData['national_code'],
        'title' => $package->title,
        'tga_status' => $package->tga_status,
    ]);
});

test('update an existing package with missing national_code', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $package = Package::factory()->create();
    $updatedData = [
        'title' => 'Updated Package Title',
        'tga_status' => 'Current',

        // Optional fields can be null
        'course_id' => null,
    ];

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->putJson(route('api.v1.packages.update', $package->id), $updatedData); // call '/api/v1/packages'

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['national_code']);
});
