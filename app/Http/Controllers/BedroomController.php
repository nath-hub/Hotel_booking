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
    public function update(Request $request, Bedroom $room, $id)
    {
        $this->authorize('update', $room);

        $bedroom = Bedroom::find($id);
        $bedroom->update($request->all());
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
