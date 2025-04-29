<?php

use App\Models\Package;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

// Necessary to access Laravel testing helpers and database factory stuff
uses(
    RefreshDatabase::class
);

test('API creates new package (full details)', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $package = Package::factory()->make()->toArray();
//    dd($package);  // Inspect the generated data


    $nationalCode = $package['national_code'];
    $title = $package['title'];
    $tgaStatus = $package['tga_status'];

    $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token,])
        ->postJson(route('api.v1.packages.store', $package)); // call '/api/v1/packages'

//    dd($response->json());  // Inspect the response JSON

    $response->assertStatus(201)
        ->assertJsonStructure([
            'success',
            'message',
            'data' =>
                [
                    'national_code',
                    'title',
                    'tga_status',
                    'created_at',
                    'updated_at',
                    'id',
                ]
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Package Added',
            'data' => [
                'national_code' => $nationalCode,
                'title' => $title,
                'tga_status' => $tgaStatus,
            ]
        ]);


    $package = Package::where('national_code', $nationalCode)->first();
    $this->assertNotNull($package);
    $this->assertTrue(Carbon::parse($package->created_at)->diffInSeconds(now()) <= 5);
    $this->assertTrue(Carbon::parse($package->updated_at)->diffInSeconds(now()) <= 5);

});

test('API creates new package (national_code, title, tga_status only)', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $package = Package::factory()->make(
        [
            'course_id' => null,
        ]
    )->toArray();

    $nationalCode = $package['national_code'];
    $title = $package['title'];
    $tgaStatus = $package['tga_status'];


    $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token,])
        ->postJson(route('api.v1.packages.store', $package)); // call '/api/v1/packages'

    $response->assertStatus(201)
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
            'message' => 'Package Added',
            'data' => [
                'national_code' => $nationalCode,
                'title' => $title,
                'tga_status' => $tgaStatus,
            ]
        ]);

    $package = Package::where('national_code', $nationalCode)->first();
    $this->assertNotNull($package);
    $this->assertTrue(Carbon::parse($package->created_at)->diffInSeconds(now()) <= 5);
    $this->assertTrue(Carbon::parse($package->updated_at)->diffInSeconds(now()) <= 5);

});

test('an error is returned when national_code, title, and tga_status are not provided', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;


    $data = [
        'course_id' => 1,
    ];

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->postJson(route('api.v1.packages.store'), $data); // call '/api/v1/packages'

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['national_code', 'title', 'tga_status']);
});



