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

test('can delete a lesson', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    Role::firstOrCreate(['name' => 'Staff']);
    Role::firstOrCreate(['name' => 'Student']);
    $staff = User::factory()->create();
    $staff->assignRole('Staff');

    $student1 = User::factory()->create();
    $student2 = User::factory()->create();
    $student1->assignRole('Student');
    $student2->assignRole('Student');

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
        'name' => $cluster->title,
        'start_date' => '2025-02-03',
        'end_date' => '2025-06-30',
        'start_time' => '09:00',
        'weekday' => 'Monday',
        'duration' => 2.0,
    ]);

    $lesson->staff()->attach($staff);
    $lesson->students()->attach([$student1->id, $student2->id]);

    expect(Lesson::find($lesson->id))->not->toBeNull();

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->deleteJson(route('api.v1.lessons.destroy', $lesson->id));

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Lesson deleted successfully.',
            'data' => null
        ]);

    expect(Lesson::find($lesson->id))->toBeNull();
});

test('lesson deletion removes pivote table relationships', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    Role::firstOrCreate(['name' => 'Staff']);
    Role::firstOrCreate(['name' => 'Student']);

    $staff = User::factory()->create();
    $staff->assignRole('Staff');
    $student = User::factory()->create();
    $student->assignRole('Student');

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
        'name' => $cluster->title,
        'start_date' => '2025-02-03',
        'end_date' => '2025-06-30',
        'start_time' => '09:00',
        'weekday' => 'Monday',
        'duration' => 2.0,
    ]);

    $lesson->staff()->attach($staff);
    $lesson->students()->attach($student);

    expect($lesson->staff()->count())->toBe(1);
    expect($lesson->students()->count())->toBe(1);

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->deleteJson(route('api.v1.lessons.destroy', $lesson->id));

    $response->assertStatus(200);

    $this->assertDatabaseMissing('lesson_user', [
        'lesson_id' => $lesson->id,
        'user_id' => $staff->id
    ]);

    $this->assertDatabaseMissing('lesson_user', [
        'lesson_id' => $lesson->id,
        'user_id' => $student->id
    ]);
});

it('returns error when trying to delete a non-existent lesson', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $nonExistentId = 999999;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->deleteJson(route('api.v1.lessons.destroy', $nonExistentId));

    $response->assertStatus(404);
});

