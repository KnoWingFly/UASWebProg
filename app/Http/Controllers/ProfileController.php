<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();
    
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'avatar' => 'nullable|image|mimes:jpeg,png,gif|max:2048' 
        ]);
    
        try {
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
    
            // Password update
            if (!empty($validatedData['password'])) {
                $user->password = Hash::make($validatedData['password']);
            }
    
            // Avatar upload handling
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                
                // Generate a unique filename
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                
                // Delete old avatar if exists
                if ($user->profile_photo_path) {
                    Storage::disk('public')->delete('profile/' . $user->profile_photo_path);
                }
    
                // Store new avatar with unique name
                $file->storeAs('profile', $filename, 'public');
                
                // Update user's profile photo path
                $user->profile_photo_path = $filename;
            }
    
            $user->save();
    
            // Prepare avatar URL for response
            $avatarUrl = $user->profile_photo_path 
                ? asset('storage/profile/' . $user->profile_photo_path) 
                : asset('storage/profile/default.jpg');
    
            return response()->json([
                'message' => 'Profile updated successfully',
                'user' => $user,
                'avatar' => $avatarUrl
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}