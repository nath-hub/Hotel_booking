<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\Facades\UserFacade as UserService;
use App\Http\Requests\UserRequest;
use App\Models\People;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(UserRequest $request)
    {

        $this->authorize('index', User::class);

        $input = $request->validated();

        $input['type'] = 'RECEPTIONIST';

        $userAuthenticated = $request->user();

        return UserService::index($userAuthenticated, $input);
    }

    /**
     * Display a listing of the resource.
     */
    public function store(UserRequest $request)
    {

        $this->authorize('createReceptionist', User::class);

        $input = $request->validated();

        $input['type'] = 'RECEPTIONIST';

        $userAuthenticated = $request->user();

        $data = UserService::store($userAuthenticated, $input);

        return response()->json([
            'code' => 201,
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

        $this->authorize('show', $user);

        $data = UserService::show($user);


        return response()->json([
            'code' => 200,
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
     * Update the specified resource in storage.
     */
    public function uploadAvatar(UserRequest $request, User $user)
    {
        $this->authorize('uploadAvatar', $user);

        $data = UserService::uploadAvatar($request->file('avatar_file'));

        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserRequest $request, User $user)
    {

       $this->authorize('delete', $user);

        $userAutenticated = $request->user();

        UserService::delete($userAutenticated, $user);

        return response()->json([], 204);
    }
}
