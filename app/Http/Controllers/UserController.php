<?php

namespace App\Http\Controllers;

use App\Services\Facades\UserFacade as UserService;
use App\Http\Requests\UserRequest;
use App\Models\People;

class UserController extends Controller
{

    public function store(UserRequest $request)
    {
        $this->authorize('createReceptionist', User::class);

        $input = $request->validated();

        $userAuthenticated = $request->user();

        $data = UserService::store($userAuthenticated, $input);

        return response()->json([
            'code' => 201,
            'data' => $data
        ]);
    }

    public function update(UserRequest $request, $user)
    {

        $this->authorize('update', $user);

        $input = $request->validated();

        $userAuthenticated = $request->user();

        UserService::update($userAuthenticated, $user, $input);

        return response()->json([], 204);
    }
}
