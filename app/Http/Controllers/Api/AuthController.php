<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:4|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        if ($request->hasFile('photo')) {
            $imageName = $request->file('photo')->store('images/users', 'public');
        } else {
            $imageName = 'images/users/defaultUser.png';
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $imageName,
        ]);
        $user->assignRole('user');

        $data = [
            'name' => $user->name,
            'photo' => $user->image_url,
        ];

        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
        return response()->json(['message' => 'user created successfully', 'user' => $data, 'token' => $token], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'invalid credentials'], 401);
        }

        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
        $data = [
            'name' => $user->name,
            'photo' => $user->image_url,
        ];

        return response()->json(['user' => $data, 'token' => $token], 200);
    }

    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();
        return response()->json(['message' => 'logged out'], 200);
    }
}
