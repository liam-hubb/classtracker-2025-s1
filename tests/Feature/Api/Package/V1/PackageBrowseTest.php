<?php

use App\Models\User;
use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;


// Necessary to access Laravel testing helpers and
// database factories as needed

uses(
    RefreshDatabase::class
);

test('five packages are created and returned in the list', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $packages = Package::factory()->count(5)->create();

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->getJson(route('api.v1.packages.index'));



    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'data' => [ // paginated structure: this is the actual array of packages
                    '*' => [
                        'id',
                        'national_code',
                        'title',
                        'tga_status',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]
        ])

        ->assertJsonCount(5, 'data.data');

    foreach ($packages as $package) {
        $response->assertJsonFragment([
            'id' => $package->id,
            'national_code'=> $package->national_code,
            'title'=> $package->title,
            'tga_status'=> $package->tga_status,
        ]);
    }

});

test('index returns 404 when no packages exist', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->getJson(route('api.v1.packages.index'));

    $response->assertStatus(404)
        ->assertJson([
            'success' => false,
            'message' => 'No Packages Found',
            'data' => []
        ]);
});
