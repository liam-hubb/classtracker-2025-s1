<?php

use App\Models\Cluster;
use App\Models\Course;
use App\Models\User;
use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(
    RefreshDatabase::class
);

test('update an existing lesson with data (lesson and user)', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    Role::firstOrCreate(['name' => 'Staff']);
    Role::firstOrCreate(['name' => 'Student']);
    $initialStaff = User::factory()->create();
    $initialStaff->assignRole('Staff');

    $initialStudent = User::factory()->create();
    $initialStudent->assignRole('Student');

    // Create new users for update
    $newStaff1 = User::factory()->create();
    $newStaff2 = User::factory()->create();
    $newStaff1->assignRole('Staff');
    $newStaff2->assignRole('Staff');

    $newStudent1 = User::factory()->create();
    $newStudent2 = User::factory()->create();
    $newStudent3 = User::factory()->create();
    $newStudent1->assignRole('Student');
    $newStudent2->assignRole('Student');
    $newStudent3->assignRole('Student');

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
        'name' => 'Original Lesson Name',
        'start_date' => '2025-02-03',
        'end_date' => '2025-06-30',
        'start_time' => '09:00',
        'weekday' => 'Monday',
        'duration' => 2.5,
    ]);

    $lesson->staff()->attach($initialStaff);
    $lesson->students()->attach($initialStudent);

    expect($lesson->staff()->count())->toBe(1);
    expect($lesson->students()->count())->toBe(1);

    $updateData = [
        'course_id' => $course->national_code,
        'cluster_id' => $cluster->code,
        'name' => 'Updated Lesson Name',
        'start_date' => '2025-03-01',
        'end_date' => '2025-07-31',
        'start_time' => '14:00',
        'weekday' => 'Wednesday',
        'duration' => 3.0,
        'staff_ids' => [$newStaff1->id, $newStaff2->id],
        'student_ids' => [$newStudent1->id, $newStudent2->id, $newStudent3->id],
    ];

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->putJson(route('api.v1.lessons.update', $lesson->id), $updateData);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Lesson updated successfully.',
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
                ]
        ]);

    $response->assertJsonFragment([
        'id' => $lesson->id,
        'name' => 'Updated Lesson Name',
        'start_date' => '2025-03-01',
        'end_date' => '2025-07-31',
        'start_time' => '14:00',
        'weekday' => 'Wednesday',
        'duration' => 3.0,
    ]);

    $lesson->refresh();
    expect($lesson->staff()->count())->toBe(2);
    expect($lesson->students()->count())->toBe(3);

    $staffIds = $lesson->staff()->pluck('users.id')->toArray();
    expect($staffIds)->toContain($newStaff1->id);
    expect($staffIds)->toContain($newStaff2->id);
    expect($staffIds)->not->toContain($initialStaff->id);

    $studentIds = $lesson->students()->pluck('users.id')->toArray();
    expect($studentIds)->toContain($newStudent1->id);
    expect($studentIds)->toContain($newStudent2->id);
    expect($studentIds)->toContain($newStudent3->id);
    expect($studentIds)->not->toContain($initialStudent->id);
});

test('update returns 404 for non-existent lesson', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $nonExistentId = 999999;
    $updateData = [
        'name' => 'Updated Name',
    ];

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->putJson(route('api.v1.lessons.update', $nonExistentId), $updateData);

    $response->assertStatus(404);
});
