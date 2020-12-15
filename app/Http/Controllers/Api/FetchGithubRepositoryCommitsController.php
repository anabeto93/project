<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FetchRepositoryCommitsFormRequest;
use App\Support\Github\CommitsAPI;
use Illuminate\Http\Request;

class FetchGithubRepositoryCommitsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(FetchRepositoryCommitsFormRequest $request)
    {
        $response = app(CommitsAPI::class)->fetchAll(
            $request->input('github_username'),
            $request->input('repository')
        );

        if (!$response) {
            return response()->json([
                'status' => 'Failed',
                'reason' => "Commits not found.",
            ], 404);
        }

        return response()->json([
            'status' => 'Success',
            'reason' => 'Commits found.',
            'data' => [
                'commits' => $response->toArray(),
            ],
        ], 200);
    }
}
