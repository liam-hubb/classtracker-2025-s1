<?php

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\DeletePackagesRequest;
use App\Http\Requests\v1\StorePackagesRequest;
use App\Http\Requests\v1\UpdatePackagesRequest;
use App\Models\Course;
use App\Models\Package;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * PackageApiController
 *
 * Handles operations related to Package management.
 *
 * Filename:        PackageApiController.php
 * Location:        app/Http/Controllers/PackageApiController.php
 * Project:         classtracker-2025-s1
 * Date Created:    14/04/2025
 *
 * Author:          Yui_Migaki
 */

/**
 * API Version 1 - PackageApiController
 */
class PackageApiController extends Controller
{
    /**
     * Returns a list of the Packages.
     */
    public function index(Request $request): JsonResponse
    {

        $packageNumber = $request->perPage;
        $search = $request->search;

        $query = Package::with('courses');

        $searchableFields = ['course', 'national_code', 'title', 'tga_status'];

        if ($search) {
            foreach ($searchableFields as $field) {
                $query->orWhere($field, 'like', '%' . $search . '%');
            }
        }

        $packages = $query->paginate($packageNumber ?? 6);

        if ($packages->isNotEmpty()) {
            return ApiResponse::success($packages, "All Packages Found");
        }

        return ApiResponse::error([], "No Packages Found", 404);
    }

    /**
     * Display the specified Package.
     */
    public function show($id): JsonResponse
    {
        $package = Package::with('courses')->find($id);
        if ($package) {
            return ApiResponse::success($package, "Specific Package Found");
        }

        return ApiResponse::error([], "Specific Package Not Found", 404);
    }

    /**
     * Create & Store a new Package resource.
     *
     * @param \App\Http\Requests\v1\StorePackagesRequest $request
     * @return JsonResponse
     */
    public function store(StorePackagesRequest $request): JsonResponse
    {
        $package = Package::create($request->validated());

        foreach ($request->course_ids as $course_id) {
            $course = Course::find($course_id);
            $course->update(['package_id' => $package->id]);
        }

        //Load the courses relationship
        $package->load('courses');

        return ApiResponse::success($package, "Package Added", 201);
    }

    /**
     * Update the specified Package resource.
     */
    public function update(UpdatePackagesRequest $request, Package $package): JsonResponse
    {
        $package->update($request->validated());


        $oldCourses = Course::where('package_id', $package->id)->get();
        foreach ($oldCourses as $oldCourse) {
            $oldCourse->update(['package_id' => null]);
        }

        foreach ($request->course_ids as $course_id) {
            $course = Course::find($course_id);
            $course->update(['package_id' => $package->id]);
        }

        //Load the courses relationship
        $package->load('courses');

        return ApiResponse::success($package, "Package Updated");
    }

    /**
     * Delete the specified Package from storage.
     */
    public function destroy(DeletePackagesRequest $request, Package $package): JsonResponse
    {
        $package->delete();
        return ApiResponse::success($package, "Package Deleted");
    }
}
