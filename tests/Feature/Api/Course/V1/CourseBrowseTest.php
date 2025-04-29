<?php

use App\Models\User;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;


// Necessary to access Laravel testing helpers and
// database factories as needed

uses(
    RefreshDatabase::class
);

test('five courses are created and returned in the list', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $courses = Course::factory()->count(5)->create();

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->getJson(route('api.v1.courses.index'));



    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'data' => [ // paginated structure: this is the actual array of courses
                    '*' => [
                        'id',
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
                        'updated_at'
                    ]
                ]
            ]
        ])

        ->assertJsonCount(5, 'data.data');

    foreach ($courses as $course) {
        $response->assertJsonFragment([
            'id' => $course->id,
            'national_code'=> $course->national_code,
            'aqf_level'=> $course->aqf_level,
            'title'=> $course->title,
            'tga_status'=> $course->tga_status,
            'state_code'=> $course->state_code,
            'nominal_hours' => (string) $course->nominal_hours,
            'type'=> $course->type,
            'qa'=> $course->qa,
            'nat_code'=> $course->nat_code,
            'nat_title'=> $course->nat_title,
            'nat_code_title'=> $course->nat_code_title
        ]);
    }

});

test('index returns 404 when no courses exist', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->getJson(route('api.v1.courses.index'));

    $response->assertStatus(404)
        ->assertJson([
            'success' => false,
            'message' => 'No Courses Found',
            'data' => []
        ]);
});
