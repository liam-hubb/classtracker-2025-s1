<?php

use App\Models\Unit;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class
);

test('five units are created an returned in the list', function() {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $unit = Unit::factory()->count(5)->create();

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->getJson(route('api.v1.units.index'));


    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'national_code',
                    'aqf_level',
                    'title',
                    'tga_status',
                    'state_code',
                    'nominal_hours',
                    'type',
                    'qa'
                ]
            ]
        ])

        ->assertJsonCount(5, 'data');

    foreach ($unit as $unit) {
        $response->assertJsonFragment([
            'id' => $unit->id,
            'national_code' => $unit->national_code,
            'aqf_level' => $unit->aqf_level,
            'title' => $unit->title,
            'tga_status' => $unit->tga_status,
            'state_code' => $unit->state_code,
            'nominal_hours' => $unit->nominal_hours,
            'type' => $unit->type,
            'qa' => $unit->qa
        ]);
    }
});

test('index returns 404 when no units exist', function() {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->getJson(route('api.v1.units.index'));

    $response->assertStatus(404)
        ->assertJson([
            'success' => false,
            'message' => 'No units found',
            'data' => []
        ]);
});
