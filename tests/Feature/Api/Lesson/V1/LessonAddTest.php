<?php

use App\Models\Cluster;
use App\Models\Course;
use App\Models\User;
use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;

uses(
    RefreshDatabase::class
);

test('API creates new lesson (full details)', function () {
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

    $lessonData = [
        'course_id' => $course->national_code,
        'cluster_id' => $cluster->code,
        'name' => $cluster->title,
        'start_date' => '2025-02-03',
        'end_date' => '2025-06-30',
        'start_time' => '09:00',
        'weekday' => 'Monday',
        'duration' => 2.0,
        'staff_ids' => [$staff->id],
        'student_ids' => [$student1->id, $student2->id, $student3->id],
    ];

    $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token,])
        ->postJson(route('api.v1.lessons.store'), $lessonData);

//    dd($response->json());
    $response->assertStatus(201)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
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
        ])

        ->assertJson([
            'success' => true,
            'message' => 'Lesson created successfully.',
            'data' => [
                'course_id' => $lessonData['course_id'],
                'cluster_id' => $lessonData['cluster_id'],
                'name' => $lessonData['name'],
                'start_date' => $lessonData['start_date'],
                'end_date' => $lessonData['end_date'],
                'start_time' => $lessonData['start_time'],
                'weekday' => $lessonData['weekday'],
                'duration' => (int) $lessonData['duration'],
            ]]);

    $lesson = Lesson::whereName($lessonData['name'])->first();
    $this->assertNotNull($lesson);
    $this->assertTrue(Carbon::parse($lesson->created_at)->diffInSeconds(now()) <= 5);
    $this->assertTrue(Carbon::parse($lesson->updated_at)->diffInSeconds(now()) <= 5);

    $this->assertDatabaseHas('lesson_user', [
        'lesson_id' => $lesson->id,
        'user_id' => $staff->id,
    ]);

    foreach ($lessonData['student_ids'] as $studentId) {
        $this->assertDatabaseHas('lesson_user', [
            'lesson_id' => $lesson->id,
            'user_id' => $studentId,
        ]);
    }
//    dd($response->getContent());
});

test('an error is returned when name is not provided', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $data = ['description' => 'A lesson without a name'];

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->postJson(route('lessons.store'), $data);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['name']);
});



