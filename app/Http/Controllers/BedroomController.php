<?php

namespace App\Http\Controllers;

use App\Models\Bedroom;
use Illuminate\Http\Request;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Bedroom $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bedroom $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bedroom $room, $id)
    {
        $this->authorize('update', $room);

        $bedroom=Bedroom::find($id);
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
