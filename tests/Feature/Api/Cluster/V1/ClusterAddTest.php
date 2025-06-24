<?php

use App\Models\Cluster;
use App\Models\User;
use Illuminate\Support\Carbon;
use function Pest\Laravel\postJson;
use function PHPUnit\Framework\assertJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test ('API creates new cluster (full details)', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $cluster = Cluster::factory()->make()->toArray();

    $code = $cluster['code'];
    $title = $cluster['title'];
    $qualification = $cluster['qualification'];
    $qualification_code = $cluster['qualification_code'];
    $unit_id = $cluster['unit_id'];
    $unit_1 = $cluster['unit_1'];
    $unit_2 = $cluster['unit_2'];
    $unit_3 = $cluster['unit_3'];
    $unit_4 = $cluster['unit_4'];
    $unit_5 = $cluster['unit_5'];
    $unit_6 = $cluster['unit_6'];
    $unit_7 = $cluster['unit_7'];
    $unit_8 = $cluster['unit_8'];

    $response = $this->withHeaders(['Authorization' => 'Bearer' . $token,])
        ->postJson(route('api.v1.clusters.store'), $cluster);

    $response->assertStatus(201)
    ->assertJson([
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
            'message' => 'cluster added',
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

    $cluster = Cluster::where('cluster_code', $code)->first();
    $this->assertNotNull($cluster);
    $this->assertTrue(Carbon::parse($cluster->created_at)->diffInSeconds(now()) > 5);
    $this->assertTrue(Carbon::parse($cluster->updated_at)->diffInSeconds(now()) > 5);
});
test('API creates new clusters (code, title, qualification, qualification_code, unit_id, all units)', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $cluster = Cluster::factory()->make(
        [
            'unit_5' => null,
            'unit_6' => null,
            'unit_7' => null,
            'unit_8' => null,
        ]
    )->toArray();

    $code = $cluster['code'];
    $title = $cluster['title'];
    $qualification = $cluster['qualification'];
    $qualification_code = $cluster['qualification_code'];
    $unit_id = $cluster['unit_id'];
    $unit_1 = $cluster['unit_1'];
    $unit_2 = $cluster['unit_2'];
    $unit_3 = $cluster['unit_3'];
    $unit_4 = $cluster['unit_4'];
    $unit_5 = $cluster['unit_5'];
    $unit_6 = $cluster['unit_6'];
    $unit_7 = $cluster['unit_7'];
    $unit_8 = $cluster['unit_8'];

    $response = $this->withHeaders(['Authorization' => 'Bearer' . $token,])
        ->postJson(route('api.v1.clusters.store'), $cluster);
    $response->assertStatus(201)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
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
            'message' => 'cluster added',
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

    $cluster = Cluster::where('cluster_code', $code)->first();
    $this->assertNotNull($cluster);
    $this->assertTrue(Carbon::parse($cluster->created_at)->diffInSeconds(now()) > 5);
    $this->assertTrue(Carbon::parse($cluster->updated_at)->diffInSeconds(now()) > 5);
});

test('an error is returned when code, title, qualification are not provided', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $data = [
        'unit_1' => 'FFF0',
        'unit_2' => 'FFF0',
        'unit_3' => 'FFF0',
        'unit_4' => 'FFF0',
        'unit_5' => 'FFF0',
        'unit_6' => 'FFF0',
        'unit_7' => 'FFF0',
        'unit_8' => 'FFF0',
    ];

    $response = $this->withHeaders('Authorization', 'Bearer' . $token)
        ->postJson(route('api.v1.clusters.store'), $data);

    $response->assertStatus(422)
        ->assertJsonValidationErrors([
            'qualification_code',
        ]);
});
