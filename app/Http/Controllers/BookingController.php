<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Services\Facades\BookingFacade as BookingService;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BookingRequest $request)
    {

        $this->authorize('index', Booking::class);

        $input = $request->validated();

        $userAuthenticated = $request->user();

        return BookingService::index($userAuthenticated, $input);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingRequest $request)
    {

        $input = $request->validated();

        $this->authorize('create', [Booking::class, $input]);

        $userAuthenticated = $request->user();

        $data = BookingService::store($userAuthenticated, $input);

        return $data;
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $this->authorize('show', [$booking]);

        return BookingService::show($booking);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookingRequest $request, Booking $booking)
    {

        $input = $request->validated();

        $this->authorize('update', [$booking, $input]);

        $data = BookingService::update($booking, $input);

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
