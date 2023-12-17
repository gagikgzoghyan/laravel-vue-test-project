<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $token = auth()->user()->createToken('global')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'user' => auth()->user()
            ]);
        }

        return response()->json(['message' => 'Credentials are wrong!'], 400);
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $userdata = $request->validated();
        $userdata['password'] = Hash::make($userdata['password']);

        $user = User::create($userdata);
        $user->assignRole('user');

        $token = $user->createToken('global')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user' => $user
        ]);
    }
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->user()->tokens()->delete();

        return response()->json(['message' => 'You have successfully logout.']);
    }

}
