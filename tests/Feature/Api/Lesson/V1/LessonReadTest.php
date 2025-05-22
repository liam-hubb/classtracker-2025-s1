<?php

use App\Models\Cluster;
use App\Models\Course;
use App\Models\User;
use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

test('lesson exists and is returned correctly with staff and students', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    Role::firstOrCreate(['name' => 'Staff']);
    Role::firstOrCreate(['name' => 'Student']);
    $staff1 = User::factory()->create(['given_name' => 'Staff1']);
    $staff2 = User::factory()->create(['given_name' => 'Staff2']);
    $staff1->assignRole('Staff');
    $staff2->assignRole('Staff');
    $student1 = User::factory()->create(['given_name' => 'Student1']);
    $student2 = User::factory()->create(['given_name' => 'Student2']);
    $student3 = User::factory()->create(['given_name' => 'Student3']);
    $student1->assignRole('Student');
    $student2->assignRole('Student');
    $student3->assignRole('Student');

    $course = Course::create([
        'national_code' => 'BSB52415',
        'aqf_level' => 'Diploma',
        'title' => 'Diploma of Marketing and Communication',
        'tga_status' => 'Current',
        'state_code' => 'AVU7',
        'nominal_hours' => '120',
        'type' => 'Qualification',
        'qa' => 'AVU7',
        'nat_code' => 'BSB52415',
        'nat_title' => 'Marketing',
        'nat_code_title' => 'BSB52415 - Marketing Fundamentals',
    ]);

    $cluster = Cluster::create([
        'code' => 'APPYTHON',
        'title' => 'Programming Basics',
    ]);

    $lesson = Lesson::create([
        'course_id' => $course->national_code,
        'cluster_id' => $cluster->code,
        'name' => 'Advanced Programming Concepts',
        'start_date' => '2025-02-03',
        'end_date' => '2025-06-30',
        'start_time' => '09:00',
        'weekday' => 'Monday',
        'duration' => 2.5,
    ]);

    $lesson->staff()->attach([$staff1->id, $staff2->id]);
    $lesson->students()->attach([$student1->id, $student2->id, $student3->id]);

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->getJson(route('api.v1.lessons.show', $lesson->id));

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Lesson retrieved successfully.',
        ])
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'course_id',
                'cluster_id',
                'name',
                'start_date',
                'end_date',
                'start_time',
                'weekday',
                'duration',
                'staff' => [
                    '*' => [
                        'id',
                        'given_name',
                        'email'
                    ]
                ],
                'students' => [
                    '*' => [
                        'id',
                        'given_name',
                        'email'
                    ]
                ]
            ]]);

    $response->assertJsonFragment([
        'id' => $lesson->id,
        'course_id' => $lesson->course_id,
        'cluster_id' => $lesson->cluster_id,
        'name' => $lesson->name,
        'start_date' => $lesson->start_date,
        'end_date' => $lesson->end_date,
        'start_time' => $lesson->start_time,
        'weekday' => $lesson->weekday,
        'duration' => $lesson->duration,
    ]);

    // Assert staff data is included
    // ReadTest help from: https://claude.ai/chat/a1ccd5bb-7b8c-4b22-8e09-884b7ffb3f5b
    $responseData = $response->json('data');
    expect($responseData['staff'])->toHaveCount(2);

    $staffIds = collect($responseData['staff'])->pluck('id')->toArray();
    expect($staffIds)->toContain($staff1->id);
    expect($staffIds)->toContain($staff2->id);

    // Assert student data is included
    expect($responseData['students'])->toHaveCount(3);

    $studentIds = collect($responseData['students'])->pluck('id')->toArray();
    expect($studentIds)->toContain($student1->id);
    expect($studentIds)->toContain($student2->id);
    expect($studentIds)->toContain($student3->id);
});

test('lesson does not exist and returns 404', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $nonExistentLessonId = 999999;

    $response = $this->withHeader('Authorization', 'Bearer '.$token)
        ->getJson(route('lessons.show', $nonExistentLessonId));

    $response->assertStatus(404);
});
