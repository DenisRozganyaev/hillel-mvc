<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (!auth()->attempt($fields)) {
            return response()->json(['message' => 'There are no valid data in request params'], 422);
        }

        return auth()->user()->createToken($request->device_name ?? 'api')->plainTextToken;
    }
}
