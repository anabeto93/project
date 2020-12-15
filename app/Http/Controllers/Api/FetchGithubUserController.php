<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FetchUserFormRequest;
use App\Support\Github\CommitsAPI;
use Illuminate\Http\Request;

class FetchGithubUserController extends Controller
{
    public function __invoke(FetchUserFormRequest $request)
    {
        $response = app(CommitsAPI::class)->getUser($request->input('github_username'));

        if (!$response) {
            return response()->json([
                'status' => 'Failed.',
                'reason' => 'Github user account not found.',
            ], 404);
        }
        return response()->json([
            'status' => 'Success',
            'reason' => 'Github account found.',
            'data' => [
                'name' => $response->full_name,
                'email' => $response->email,
                'avatar' => $response->avatar,
            ],
        ], 200);
    }
}
