<?php

namespace App\Http\Controllers;

use App\Services\Facades\ReceptionistFacade as Receptionist;
use App\Http\Requests\ReceptionistRequest;

class ReceptionistController extends Controller
{

    public function store(ReceptionistRequest $request)
    {

        $input = $request->validated();

        $user = $request->user();

        $data = Receptionist::store($user, $input);

        return response()->json([
            'code' => 201,
            'data' => $data
        ]);
    }
}
