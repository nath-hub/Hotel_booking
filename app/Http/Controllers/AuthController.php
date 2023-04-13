<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if (Auth::attempt($data)) {

            $user = $request->user();

            $token = $user->createToken('API TOKEN');

            $people = $user->people;

            return response()->json([
                'code' => 200,
                'data' => [
                    'token' => [
                        'type' => 'Bearer',
                        'expires_at' =>  Carbon::parse($token->accessToken->expires_at),
                        'access_token' => $token->plainTextToken
                    ],
                    'user' => [
                        'username' => $user->name,
                        'email' => $user->email,
                        'firstname' => $people->firstname,
                        'lastname' => $people->lastname,
                        'type' => $people->type,
                    ]
                ]
            ]);
        }

        return response()->json([
            'code' => 401,
            'error' => 'invalid_client',
            'message' => 'Client authenfication failed',
        ], 401);
    }
}
