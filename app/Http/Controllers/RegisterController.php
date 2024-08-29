<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|string|unique:users',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string|same:password',
        ]);

        User::create($request->all());

        return response()->json(['message' => 'User created successfully'], 201);
    }
}
