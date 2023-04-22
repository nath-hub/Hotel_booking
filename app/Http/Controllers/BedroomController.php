<?php

namespace App\Http\Controllers;

use App\Http\Requests\BedroomRequest;
use App\Models\Bedroom;
use Illuminate\Http\Request;
use App\Services\Facades\BedroomFacade as BedroomService;

class BedroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Bedroom::class);

        return Bedroom::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BedroomRequest $request)
    {
        $this->authorize('create', Bedroom::class);

        $input = $request->validated();

        $userAuthenticated = $request->user();

        $data = BedroomService::store($userAuthenticated, $input);

        return [
            'code' => 201,
            'data' => $data,
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Bedroom $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BedroomRequest $request, Bedroom $bedroom)
    {
        $this->authorize('update', Bedroom::class);

        $input = $request->validated();

        $bedroom = BedroomService::update($bedroom, $input);
        
        return $bedroom;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bedroom $room, $id)
    {
        $this->authorize('delete', $room);

        return Bedroom::destroy($id);
    }
}
