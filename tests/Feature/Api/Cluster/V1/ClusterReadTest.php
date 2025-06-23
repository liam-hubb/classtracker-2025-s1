<?php

use App\Models\Cluster;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('units exists and is returned correctly', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $cluster = Cluster::factory()->create();

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->getJson(route('api.v1.clusters.show', $cluster->id));

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
            'message' => 'Cluster retrieved successfully.',
            'data' => [
                'id' => $cluster->id,
                'code' => $cluster->code,
                'title' => $cluster->title,
                'qualification' => $cluster->qualification,
                'qualification_code' => $cluster->qualification_code,
                'unit_id' => $cluster->unit_id,
                'unit_1' => $cluster->unit_1,
                'unit_2' => $cluster->unit_2,
                'unit_3' => $cluster->unit_3,
                'unit_4' => $cluster->unit_4,
                'unit_5' => $cluster->unit_5,
                'unit_6' => $cluster->unit_6,
                'unit_7' => $cluster->unit_7,
                'unit_8' => $cluster->unit_8,
            ]
        ]);
});

test('clusters does not exist an returns 404', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $nonExistentClusterId = 9999;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->getJson(route('api.v1.clusters.show', $nonExistentClusterId));

    $response->assertStatus(404)
        ->assertJson([
            'success' => false,
            'message' => 'Cluster not found.',
            'data' => []
        ]);
});
