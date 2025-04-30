<?php

namespace App\Http\Controllers\Api\v1;

use App\Classes\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $users = User::all();

        if ($users->count() > 0) {
            return ApiResponse::success($users, 'All users found successfully.');
        }

        return ApiResponse::error('No users found', 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $user = User::create($request->all());

        if ($user) {
            return ApiResponse::success($user, 'User created successfully', 201);
        }

        return ApiResponse::error('User could not be created', 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        if ($user) {
            return ApiResponse::success($user, 'User found successfully');
        }

        return ApiResponse::error('User not found', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $updated = $user->update($request->all());

        if ($updated) {
            return ApiResponse::success($user, 'User updated successfully');
        }

        return ApiResponse::error('User could not be updated', 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        $deleted = $user->delete();

        if ($deleted) {
            return ApiResponse::success(null, 'User deleted successfully');
        }

        return ApiResponse::error('User could not be deleted', 400);
    }
}
