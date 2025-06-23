<?php

use App\Models\Unit;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('course exists and is returned correctly', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $unit = Unit::factory()->create();

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->getJson(route('api.v1.units.show', $unit->id));

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
                    'qa'
            ]
        ])

        ->assertJson([
            'success' => true,
            'message' => 'Unit retrieved successfully.',
            'data' => [
                'id' => $unit->id,
                'national_code' => $unit->national_code,
                'aqf_level' => $unit->aqf_level,
                'title' => $unit->title,
                'tga_status' => $unit->tga_status,
                'state_code' => $unit->state_code,
                'nominal_hours' => $unit->nominal_hours,
                'type' => $unit->type,
                'qa' => $unit->qa
            ]
        ]);
});

test('course does not exist an returns 404', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $nonExistentUnitId = 999;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->getJson(route('api.v1.units.show', $nonExistentUnitId));

    $response->assertStatus(404)
        ->assertJson([
            'success' => false,
            'message' => 'Unit not found.',
            'data' => []
        ]);
});
