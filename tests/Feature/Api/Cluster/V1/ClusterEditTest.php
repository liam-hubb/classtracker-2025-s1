<?php

use App\Models\Cluster;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('update an existing cluster with new details (code, title, qualification, qualification_code, unit_id, units)', function () {
    $this->withoutExceptionHandling();

    $user = User::factory()->create();
    $this->actingAs($user);

    $token = $user->createToken('TestToken')->plainTextToken;

    $cluster = Cluster::factory()->create();

    $updatedData = Cluster::factory()->make([
        'code' => 'NEW12345',
        'title' => 'Updated Cluster Title',
        'qualification' => 'ICT9999',
        'qualification_code' => 'NEW123',
        'unit_id' => '99999',
        'unit_1' => '9999',

    ])->toArray();

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->putJson(route('api.v1.clusters.update', $cluster->id), $updatedData);

    $response
        ->assertStatus(200)

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
            'message' => 'Cluster has been updated.',
            'data' => [
                'id' => $cluster->id,
                'code' => $updatedData['code'],
                'title' => $updatedData['title'],
                'qualification' => $updatedData['qualification'],
                'qualification_code' => $updatedData['qualification_code'],
                'unit_id' => $updatedData['unit_id'],
                'unit_1' => $updatedData['unit_1'],
                'unit_2' => $updatedData['unit_2'],
                'unit_3' => $updatedData['unit_3'],
                'unit_4' => $updatedData['unit_4'],
                'unit_5' => $updatedData['unit_5'],
                'unit_6' => $updatedData['unit_6'],
                'unit_7' => $updatedData['unit_7'],
                'unit_8' => $updatedData['unit_8'],
            ]
        ]);
    $this->assertDatabaseHas('clusters', [
        'id' => $cluster->id,
        'code' => $updatedData['code'],
        'title' => $updatedData['title'],
        'qualification' => $updatedData['qualification'],
        'qualification_code' => $updatedData['qualification_code'],
        'unit_id' => $updatedData['unit_id'],
        'unit_1' => $updatedData['unit_1'],
        'unit_2' => $updatedData['unit_2'],
        'unit_3' => $updatedData['unit_3'],
        'unit_4' => $updatedData['unit_4'],
        'unit_5' => $updatedData['unit_5'],
        'unit_6' => $updatedData['unit_6'],
        'unit_7' => $updatedData['unit_7'],
        'unit_8' => $updatedData['unit_8'],
    ]);
});

test('update an existing cluster with new details (qualification_code only)', function () {
   $user = User::factory()->create();
   $token = $user->createToken('TestToken')->plainTextToken;

   $cluster = Cluster::factory()->create();

   $updatedData = Cluster::factory()->make([
       'code' => 'NEW12345',
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
   ])->toArray();

   $response = $this->withHeader('Authorization', 'Bearer ' . $token)
       ->putJson(route('api.v1.clusters.update', $cluster->id), $updatedData);

   $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => []
        ])

       ->assertJson([
           'success' => true,
           'message' => 'Cluster has been updated.',
           'data' => [
               'code' => $updatedData['code'],
               'qualification_code' => $updatedData['qualification_code'],
           ]
       ]);
   $this->assertDatabaseHas('clusters', [
       'id' => $cluster->id,
       'code' => $cluster->code,
       'title' => $cluster->title,
       'qualification' => $cluster->qualification,
       'qualification_code' => $updatedData['qualification_code'],
       'unit_id' => $cluster->unit_id,
       'unit_1' => $cluster->unit_1,
       'unit_2' => $cluster->unit_2,
       'unit_3' => $cluster->unit_3,
       'unit_4' => $cluster->unit_4,
       'unit_5' => $cluster->unit_5,
       'unit_6' => $cluster->unit_6,
       'unit_7' => $cluster->unit_7,
       'unit_8' => $cluster->unit_8,
   ]);
});

test('update an existing cluster with missing qualification code', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $cluster = Cluster::factory()->create();
    $updatedData = [
        'code' => 'NEW12345',
        'title' => 'Updated Cluster Title',
        'qualification' => 'ICT9999',
        'unit_id' => '99999',
        'unit_1' => 'FFF0',
        'unit_2' => 'FFF0',
        'unit_3' => 'FFF0',
        'unit_4' => 'FFF0',
        'unit_5' => 'FFF0',
        'unit_6' => 'FFF0',
        'unit_7' => 'FFF0',
        'unit_8' => 'FFF0',
    ];

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->putJson(route('api.v1.clusters.update', $cluster->id), $updatedData);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['qualification_code']);
});
