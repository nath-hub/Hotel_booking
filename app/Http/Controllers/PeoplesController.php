<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;
use App\Http\Requests\PeopleRequest;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', People::class);

        return People::all();
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
    public function store(PeopleRequest $request)
    {

        $this->authorize('create', People::class);

        $people = People::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(People $peoples)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(People $peoples, $id, Request $request)
    {
       //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, People $peoples, $id)
    {

        $this->authorize('update', $peoples);

        $peoples=People::find($id);
        $peoples->update($request->all());
        return $peoples;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(People $peoples, $id)
    {

        $this->authorize('delete', $peoples);

        return People::destroy($id);
    }
}
