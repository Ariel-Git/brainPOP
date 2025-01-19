<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class TokenController extends Controller
{
    /**
     * Handle a login request to the application.
     *
     * Sample Request Payload:
     * {
     *     'email': 'test@example.com',
     *     'password': 'password'
     * }
     * Sample Success Response (200):
     * {
     *     'access_token': 'TOKEN',
     *     'token_type': 'Bearer'
     * }
     * Sample Failed Response (401):
     * {
     *     'message': 'Invalid login details'
     * }
     *
     * @param \App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $token = $user->createToken('auth_token', ['*']);
        $user->tokens()->where('name', 'auth_token')->update([
            'expires_at' => now()->addHour(),
        ]);
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Carbon::now()->addHour()->timestamp,
        ]);
    }}
