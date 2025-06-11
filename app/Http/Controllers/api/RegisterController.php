<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone'     => 'required|string|max:20|unique:users',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6',
            'address'   => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'phone'     => $request->phone,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'address'   => $request->address,
            'role'      => 'user', // ← secara default
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user'    => $user
        ], 201);
    }
}
