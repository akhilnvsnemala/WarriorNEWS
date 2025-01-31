<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    // Registration method
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    // Login method
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('YourAppName')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
        ]);
    }

    // Logout method
    public function logout(Request $request)
    {
        // Revoke the user's current token
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }

     // Reset password
     public function resetPassword(Request $request)
     {
         // Validate the incoming request
         $validator = Validator::make($request->all(), [
             'email' => 'required|string|email|exists:users,email', // Ensure the email exists
             'old_password' => 'required|string|min:8', // Old password should be valid
             'password' => 'required|string|min:8|confirmed', // New password with confirmation
         ]);
 
         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()], 422);
         }
 
         // Find the user by email
         $user = User::where('email', $request->email)->first();
 
         // Check if the old password matches the current password
         if (!$user || !Hash::check($request->old_password, $user->password)) {
             return response()->json(['message' => 'Old password is incorrect'], 401);
         }
 
         // Update the user's password
         $user->password = Hash::make($request->password);
         $user->save();
 
         return response()->json(['message' => 'Password successfully updated']);
     }

}
