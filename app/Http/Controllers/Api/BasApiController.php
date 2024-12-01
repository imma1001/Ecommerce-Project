<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;


class BasApiController extends Controller{
    public function register(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // password_confirmation field required
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Proceed to register the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        // Generate a token and return response
        $token = $user->createToken('larav')->plainTextToken;
    
        return response()->json([
            'status' => 'success',
            'message' => 'Registration successful',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        // Check if the user exists and the password is correct
        if ($user && Hash::check($request->password, $user->password)) {
            // Generate an API token
            $token = $user->createToken('larav')->plainTextToken;

            // Return the user data and token
            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ], 200);
        }

        // If authentication fails
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid email or password',
        ], 401);
    }



     // Logout function
     public function logout(Request $request)
     {
       
         // Revoke the current token
        $request->user()->currentAccessToken()->delete();

 
         // Return a success message
         return response()->json([
             'status' => 'success',
             'message' => 'Logged out successfully'
         ]);
     }

     public function profile(Request $request)
    {
        // Get the currently authenticated user
        $user = $request->user();

        return response()->json([
            'status' => 'success',
            'message' => 'User profile retrieved successfully',
            'data' => $user,
        ], 200);
    }
}