<?php

use App\Models\Unit;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can delete a unit', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $unit = Unit::factory()->create();

    $nationalCode = $unit->nationalCode;
    $aqfLevel = $unit->aqf_level;
    $title = $unit->title;
    $tgaStatus = $unit->tga_status;
    $stateCode = $unit->state_code;
    $nominalHours = $unit->nominal_hours;
    $type = $unit->type;
    $qa = $unit->qa;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->deleteJson(route('api.v1.units.delete', $unit->id));

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
                'qa'
            ]
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Unit deleted',
            'data' => [
                'national_code' => $nationalCode,
                'aqf_level' => $aqfLevel,
                'title' => $title,
                'tga_status' => $tgaStatus,
                'state_code' => $stateCode,
                'nominal_hours' => $nominalHours,
                'type' => $type,
                'qa' => $qa
            ]
        ]);
    expect(Unit::find($unit->id))->toBeNull();
});

it('returns error when trying to delete a non-existent unit', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $nonExistentId = 9999;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->deleteJson(route('api.v1.units.delete', $nonExistentId));

    $response->assertStatus(404)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => []
        ])
        ->assertJson([
            'success' => false,
            'message' => 'Unit not found',
            'data' => []
        ]);
});
