<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::firstWhere('email', $data['email']);

        if (Hash::check($data['password'], $user->password)) {

            $token = $user->createToken('API TOKEN')->plainTextToken;

            $people = $user->people;

            return response()->json([
                'code' => 200,
                'data' => [
                    'token' => [
                        'type' => 'Bearer',
                        'access_token' => $token
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
