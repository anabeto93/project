<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiLoginFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(ApiLoginFormRequest $request)
    {
        $user = User::whereEmail($request->email)->first();

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' =>'Unauthenticated',
                'reason' => "Invalid user credentials",
            ], 401);
        }

        return response()->json([
            'status' => 'Success',
            'reason' => 'Authentication successful.',
            'data' => [
                'token' => $user->createToken('FreshinUp')->plainTextToken,
                'type' => 'Bearer',
                'ttl' => 3600,
            ],
        ], 200);
    }
}
