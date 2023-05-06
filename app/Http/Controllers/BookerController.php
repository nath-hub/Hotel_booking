<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Facades\UserFacade as UserService;

class BookerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $this->authorize('createBooker', User::class);

        $input = $request->validated();

        $input["type"] = "ADULT";

        $userAuthenticated = $request->user();

        $data = UserService::store($userAuthenticated, $input);

        return response()->json([
            'code' => 201,
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $input = $request->validated();

        $userAuthenticated = $request->user();

        UserService::update($userAuthenticated, $user, $input);

        return response()->json([], 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
