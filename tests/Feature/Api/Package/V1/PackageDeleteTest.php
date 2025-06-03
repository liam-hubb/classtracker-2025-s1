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

uses(RefreshDatabase::class);

it('can delete a package', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $package = Package::factory()->create();

    $nationalCode = $package->national_code;
    $title = $package->title;
    $tgaStatus = $package->tga_status;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->deleteJson(route('api.v1.packages.destroy', $package->id));

    $response->assertStatus(200)
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
            'message' => 'Package Deleted',
            'data' => [
//                'id' => $package->id,
                'national_code' => $nationalCode,
                'title' => $title,
                'tga_status' => $tgaStatus,
            ]
        ]);

    expect(Package::find($package->id))->toBeNull();
});

it('returns error when trying to delete a non-existent package', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $nonExistentId = 9999;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->deleteJson(route('api.v1.packages.destroy', $nonExistentId));

//    $response->assertStatus(404)
//        ->assertJson([
//            'success' => false,
//            'message' => 'No Packages Found',
//            'data' => []
//        ]);

    $response->assertStatus(404)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => []
        ])
        ->assertJson([
            'success' => false,
            'message' => 'Specific Package Not Found',
            'data' => []
        ]);
});



