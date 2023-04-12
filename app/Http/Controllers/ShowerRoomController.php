<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowerRoomRequest;
use App\Models\ShowerRoom;
use Illuminate\Http\Request;

class ShowerRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', ShowerRoom::class);
            
        return ShowerRoom::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShowerRoomRequest $request)
    {
        $this->authorize('create', ShowerRoom::class);

        $people = ShowerRoom::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowerRoom $shower_room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShowerRoom $shower_room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShowerRoom $shower_room, $id)
    {
        $this->authorize('update', $shower_room);

        $shower_room=ShowerRoom::find($id);
        $shower_room->update($request->all());
        return $shower_room;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShowerRoom $shower_room, $id)
    {
        $this->authorize('delete', $shower_room);

        return ShowerRoom::destroy($id);
    }
}
