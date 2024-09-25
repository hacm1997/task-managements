<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    // Method to get a user by ID
    public function getUserById($id)
    {
        // Find user by ID, fail if not found
        $user = User::findOrFail($id);

        // Return user in JSON format
        return response()->json(['user' => $user], 200);
    }

    // Method to get all users
    public function getAllUsers(Request $request)
    {
        // Check if the authenticated user has an admin role
        if (Auth::user()->role === 'admin') {
            // Optionally implement pagination for large datasets
            $users = User::paginate($request->get('per_page', 10));

            // Return users list in JSON format
            return response()->json(['users' => $users], 200);
        }

        // Return unauthorized response for non-admin users
        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
