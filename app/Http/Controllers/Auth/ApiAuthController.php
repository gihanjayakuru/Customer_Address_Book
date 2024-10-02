<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     * @var \App\Models\User $user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            // $user = Auth::user();
            $token = $request->user()->createToken('API Token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token
            ], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    /**
     * Handle user logout and revoke the token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
