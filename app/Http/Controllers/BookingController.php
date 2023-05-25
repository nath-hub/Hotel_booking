<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use Illuminate\Support\Facades\Gate;
use App\Services\Facades\BookingFacade as BookingService;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('index', User::class);

        return BookingService::index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingRequest $request)
    {

        $input = $request->validated();

        Gate::authorize('create-booking', [$input]);

        $userAuthenticated = $request->user();

        $data = BookingService::store($userAuthenticated, $input);

        return $data;
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $this->authorize('show', $booking);

        return BookingService::show($booking);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookingRequest $request, Booking $booking)
    {

        $input = $request->validated();

        Gate::authorize('update-booking', [$booking, $input]);

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
