<?php

use App\Models\Unit;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('update an existing unit with new details (national_code, aqf_level, title, tga_status, state_code, nominal_hours an type)', function () {
    $this->withoutExceptionHandling();

    $user = User::factory()->create();
    $this->actingAs($user);

    $token = $user->createToken('TestToken')->plainTextToken;

    $unit = Unit::factory()->create();

    $updatedData = Unit::factory()->make([
        'national_code' => 'NEW12345',
        'aqf_level' => 'Diploma of',
        'title' => 'Updated Unit Title',
        'tga_status' => 'Current',
        'state_code' => 'VIC0',
        'nominal_hours' => 400,
        'type' => 'Class',

        'qa' => null,
    ])->toArray();

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->putJson(route('api.v1.units.update', $unit->id), $updatedData);

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
                'qa'
            ]
        ])

        ->assertJson([
            'success' => true,
            'message' => 'Course updated',
            'data' => [
                'id' => $unit->id,
                'national_code' => $updatedData['national_code'],
                'aqf_level' => $updatedData['aqf_level'],
                'title' => $updatedData['title'],
                'tga_status' => $updatedData['tga_status'],
                'state_code' => $updatedData['state_code'],
                'nominal_hours' => $updatedData['nominal_hours'],
                'type' => $updatedData['type'],
            ]
        ]);
    $this->assertDatabaseHas('units', [
        'id' => $unit->id,
        'national_code' => $updatedData['national_code'],
        'aqf_level' => $updatedData['aqf_level'],
        'title' => $updatedData['title'],
        'tga_status' => $updatedData['tga_status'],
        'state_code' => $updatedData['state_code'],
        'nominal_hours' => $updatedData['nominal_hours'],
        'type' => $updatedData['type'],
    ]);
});

test('update an existing unit with new details (national_code only)', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $unit = Unit::factory()->create();

    $updatedData = Unit::factory()->make([
        'national_code' => 'AAA00000',
        'aqf_level' => $unit->aqf_level,
        'title' => $unit->title,
        'tga_status' => $unit->tga_status,
        'state_code' => $unit->state_code,
        'nominal_hours' => $unit->nominal_hours,
        'type' => $unit->type,

        'qa' => null,
    ])->toArray();

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->putJson(route('api.v1.units.update', $unit->id), $updatedData);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => []
        ])

        ->assertJson([
            'success' => true,
            'message' => 'Course updated',
            'data' => [
                'id' => $unit->id,
                'national_code' => $updatedData['national_code'],
            ]
        ]);
    $this->assertDatabaseHas('units', [
        'id' => $unit->id,
        'national_code' => $updatedData['national_code'],
        'aqf_level' => $unit->aqf_level,
        'title' => $unit->title,
        'tga_status' => $unit->tga_status,
        'state_code' => $unit->state_code,
        'nominal_hours' => $unit->nominal_hours,
        'type' => $unit->type,
    ]);
});

test('update an existing unit with missing national_code', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $unit = Unit::factory()->create();
    $updatedData = [
        'aqf_level' => 'Diploma of',
        'title' => 'Updated Unit Title',
        'tga_status' => 'Current',
        'state_code' => 'VIC7',
        'nominal_hours' => 400,
        'type' => 'Class',

        'qa' => null,
    ];

    $response = $this->withHeader('Authorization', 'Bearer' . $token)
        ->putJson(route('api.v1.courses.update', $unit->id), $updatedData);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['national_code']);
});
