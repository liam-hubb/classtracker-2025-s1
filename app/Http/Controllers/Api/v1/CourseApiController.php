<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Course;
use App\Classes\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreCoursesRequest;
use App\Http\Requests\v1\UpdateCoursesRequest;
use App\Http\Requests\v1\DeleteCoursesRequest;
use Illuminate\Http\JsonResponse;

/**
 * CourseApiController
 *
 * Handles operations related to Course management.
 *
 * Filename:        CourseApiController.php
 * Location:        app/Http/Controllers/CourseApiController.php
 * Project:         classtracker-2025-s1
 * Date Created:    14/04/2025
 *
 * Author:          Yui_Migaki
 */

/**
 * API Version 1 - CourseApiController
 */
class CourseApiController extends Controller
{
    /**
     * Returns a list of the Courses.
     */
    public function index(): JsonResponse
    {
        $courses = Course::all();

        if ($courses->isNotEmpty()) {
            return ApiResponse::success($courses, "All Courses Found");
        }

        return ApiResponse::error([], "No Courses Found", 404);
    }

    /**
     * Display the specified Course.
     */
    public function show($id): JsonResponse
    {
        $course = Course::find($id);

        if ($course) {
            return ApiResponse::success($course, "Specific Course Found");
        }

        return ApiResponse::error([], "Specific Course Not Found", 404);
    }


    /**
     * Create & Store a new Category resource.
     *
     * @param \App\Http\Requests\v1\StoreCoursesRequest $request
     * @return JsonResponse
     */
    public function store(StoreCoursesRequest $request): JsonResponse
    {
        $course = Course::create($request->validated());
        return ApiResponse::success($course, "Course added", 201);
    }

    /**
     * Update the specified Course resource.
     */
    public function update(UpdateCoursesRequest $request, Course $course): JsonResponse
    {
        $course->update($request->validated());
        return ApiResponse::success($course, "Course updated");
    }

    /**
     * Delete the specified Course from storage.
     */
    public function destroy(DeleteCoursesRequest $request, Course $course): JsonResponse
    {
        $course->delete();
        return ApiResponse::success($course, "Course deleted");
    }
}
