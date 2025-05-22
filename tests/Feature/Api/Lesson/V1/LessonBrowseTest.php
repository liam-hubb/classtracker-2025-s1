<?php

use App\Models\Cluster;
use App\Models\Course;
use App\Models\User;
use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

test('five lessons are created and returned in the list', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    Role::firstOrCreate(['name' => 'Staff']);
    Role::firstOrCreate(['name' => 'Student']);

    $staff = User::factory()->create();
    $staff->assignRole('Staff');

    $student1 = User::factory()->create();
    $student2 = User::factory()->create();
    $student3 = User::factory()->create();

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

    $lessons = collect();

    for ($i = 0; $i < 5; $i++) {
        $lesson = Lesson::create([
            'course_id' => $course->national_code,
            'cluster_id' => $cluster->code,
            'name' => $cluster->title,
            'start_date' => '2025-02-03',
            'end_date' => '2025-06-30',
            'start_time' => '09:00',
            'weekday' => 'Monday',
            'duration' => 2.0,
        ]);

        $lesson->staff()->attach($staff);
        $lesson->students()->attach([$student1->id, $student2->id, $student3->id]);

        $lessons->push($lesson);
    }

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
       ->getJson(route('api.v1.lessons.index'));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'data' => [
                    '*' => [
                        'id',
                        'course_id',
                        'cluster_id',
                        'name',
                        'start_date',
                        'end_date',
                        'start_time',
                        'weekday',
                        'duration',
                        'staff',
                        'students'
                    ]
                ]
            ]
        ])

        ->assertJsonCount(5, 'data.data');

    foreach ($lessons as $lesson) {
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
    }
});

test('index returns 404 when no lessons exist', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->getJson(route('api.v1.lessons.index'));

    $response->assertStatus(404)
        ->assertJson([
            'success' => false,
            'message' => 'No Lessons Found',
            'data' => []
        ]);
});

