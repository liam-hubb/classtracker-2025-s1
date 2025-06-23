<?php

use App\Models\Cluster;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can delete a cluster', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $cluster = Cluster::factory()->create();

    $code = $cluster->code;
    $title = $cluster->title;
    $qualification = $cluster->qualification;
    $qualification_code = $cluster->qualification_code;
    $unit_id = $cluster->unit_id;
    $unit_1 = $cluster->unit_1;
    $unit_2 = $cluster->unit_2;
    $unit_3 = $cluster->unit_3;
    $unit_4 = $cluster->unit_4;
    $unit_5 = $cluster->unit_5;
    $unit_6 = $cluster->unit_6;
    $unit_7 = $cluster->unit_7;
    $unit_8 = $cluster->unit_8;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->deleteJson(route('api.v1.clusters.delete', $cluster->id));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'code',
                'title',
                'qualification',
                'qualification_code',
                'unit_id',
                'unit_1',
                'unit_2',
                'unit_3',
                'unit_4',
                'unit_5',
                'unit_6',
                'unit_7',
                'unit_8',
            ]
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Cluster deleted',
            'data' => [
                'code' => $code,
                'title' => $title,
                'qualification' => $qualification,
                'qualification_code' => $qualification_code,
                'unit_id' => $unit_id,
                'unit_1' => $unit_1,
                'unit_2' => $unit_2,
                'unit_3' => $unit_3,
                'unit_4' => $unit_4,
                'unit_5' => $unit_5,
                'unit_6' => $unit_6,
                'unit_7' => $unit_7,
                'unit_8' => $unit_8,
            ]
        ]);
    expect(Cluster::find($cluster->id))->toBeNull();
});

it('returns error when trying to delete a non-existent cluster', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $nonExistentId = 9999;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->deleteJson(route('api.v1.clusters.delete', $nonExistentId));

    $response->assertStatus(404)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => []
        ])
        ->assertJson([
            'success' => false,
            'message' => 'Cluster not found',
            'data' => []
        ]);
});
