<?php

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

// Necessary to access Laravel testing helpers and database factory stuff
uses(
    RefreshDatabase::class
);

test('API creates new course (full details)', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $course = Course::factory()->make()->toArray();

    $nationalCode = $course['national_code'];
    $aqfLevel = $course['aqf_level'];
    $title = $course['title'];
    $tgaStatus = $course['tga_status'];
    $stateCode = $course['state_code'];
    $nominalHours = $course['nominal_hours'];
    $type = $course['type'];
    $qa = $course['qa'];
    $natCode = $course['nat_code'];
    $natTitle = $course['nat_title'];
    $natCodeTitle = $course['nat_code_title'];

    $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token,])
        ->postJson(route('api.v1.courses.store', $course)); // call '/api/v1/courses'

//    dd($response->getContent());

    $response->assertStatus(201)
        ->assertJsonStructure([
            'success',
            'message',
            'data' =>
                [
                    'national_code',
                    'aqf_level',
                    'title',
                    'tga_status',
                    'state_code',
                    'nominal_hours',
                    'type',
                    'qa',
                    'nat_code',
                    'nat_title',
                    'nat_code_title',
                    'created_at',
                    'updated_at',
                    'id',

                ]
        ])
        ->assertJson([
            'success' => true,
            'message' => 'Course added',
            'data' => [
                'national_code' => $nationalCode,
                'aqf_level' => $aqfLevel,
                'title' => $title,
                'tga_status' => $tgaStatus,
                'state_code' => $stateCode,
                'nominal_hours' => (string) $nominalHours,
                'type' => $type,
                'qa' => $qa,
                'nat_code' => $natCode,
                'nat_title' => $natTitle,
                'nat_code_title' => $natCodeTitle,
            ]
        ]);


    $course = Course::where('national_code', $nationalCode)->first();
    $this->assertNotNull($course);
    $this->assertTrue(Carbon::parse($course->created_at)->diffInSeconds(now()) <= 5);
    $this->assertTrue(Carbon::parse($course->updated_at)->diffInSeconds(now()) <= 5);

});

test('API creates new course (national_code, aqf_level, title, tga_status, state_code, nominal_hours and type only)', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $course = Course::factory()->make(
        [
            'qa' => null,
            'nat_code' => null,
            'nat_title' => null,
            'nat_code_title' => null,
        ]
    )->toArray();

    $nationalCode = $course['national_code'];
    $aqfLevel = $course['aqf_level'];
    $title = $course['title'];
    $tgaStatus = $course['tga_status'];
    $stateCode = $course['state_code'];
    $nominalHours = $course['nominal_hours'];
    $type = $course['type'];


    $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token,])
        ->postJson(route('api.v1.courses.store', $course)); // call '/api/v1/courses'

    $response->assertStatus(201)
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
                'created_at',
                'updated_at'
            ]
        ])

        ->assertJson([
            'success' => true,
            'message' => 'Course added',
            'data' => [
                'national_code' => $nationalCode,
                'aqf_level'=> $aqfLevel,
                'title' => $title,
                'tga_status' => $tgaStatus,
                'state_code' => $stateCode,
                'nominal_hours' => (string) $nominalHours,
                'type' => $type,
            ]
        ]);

    $course = Course::where('national_code', $nationalCode)->first();
    $this->assertNotNull($course);
    $this->assertTrue(Carbon::parse($course->created_at)->diffInSeconds(now()) <= 5);
    $this->assertTrue(Carbon::parse($course->updated_at)->diffInSeconds(now()) <= 5);

});

test('an error is returned when national_code, aqf_level, title, tga_status, state_code, nominal_hours and type are not provided', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;


    $data = [
        'qa' => 'FFF0',
        'nat_code' => 'FFF10115',
        'nat_title' => 'Test',
        'nat_code_title' => 'FFF10115 Test',
    ];

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->postJson(route('api.v1.courses.store'), $data); // call '/api/v1/courses'

    $response->assertStatus(422)

        ->assertJsonValidationErrors([
            'national_code',
            'aqf_level',
            'title',
            'tga_status',
            'state_code',
            'nominal_hours',
            'type'
        ]);});



