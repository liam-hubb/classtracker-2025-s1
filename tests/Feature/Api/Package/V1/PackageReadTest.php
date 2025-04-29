<?php

use App\Models\Package;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

// Necessary to access Laravel testing helpers and database factory stuff
uses(
    RefreshDatabase::class
);


test('package exists and is returned correctly', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $package = Package::factory()->create();

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->getJson(route('api.v1.packages.show', $package->id)); // call '/api/v1/packages'


    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' =>
                [
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
            'message' => 'Specific Package Found',
            'data' => [
                'id' => $package->id,
                'national_code'=> $package->national_code,
                'title'=> $package->title,
                'tga_status'=> $package->tga_status,
            ]
        ]);
});

test('package does not exist and returns 404', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $nonExistentPackageId = 999;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->getJson(route('api.v1.packages.show', $nonExistentPackageId)); // call '/api/v1/packages'

    $response->assertStatus(404)
        ->assertJson([
            'success' => false,
            'message' => 'Specific Package Not Found',
            'data' => []
        ]);
});
