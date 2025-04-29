<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user,
        ]);
    }
    public function profile(Request $request)
    {
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }
//    public function register(Request $request)
//    {
//        // Validate incoming request
//        $validator = Validator::make($request->all(), [
//            'email' => 'required|email|unique:users,email',
//            'password' => 'required|string|min:8|confirmed',
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json([
//                'success' => false,
//                'message' => 'Validation failed',
//                'errors' => $validator->errors(),
//            ], 422);
//        }
//
//        // Create user
//        $user = User::create([
//            'email' => $request->email,
//            'password' => Hash::make($request->password),
//        ]);
//
//        // Generate token
//        $token = $user->createToken('api-token')->plainTextToken;
//
//        return response()->json([
//            'success' => true,
//            'message' => 'User registered successfully',
//            'user' => $user,
//            'token' => $token,
//        ], 201);
//    }
}

