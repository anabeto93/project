<?php


namespace App\Support\Github;


use App\DTOs\CommitsData;
use App\DTOs\GithubUserAccount;
use App\DTOs\SingleCommitData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GithubCommitsAPI implements CommitsAPI
{
    protected string $base_url = 'https://api.github.com';
    protected string $accessToken;

    public function __construct()
    {
        $this->accessToken  = config('services.github.token');
    }

    public function fetchAll(string $owner, string $repository): ?CommitsData
    {
        $url = $this->base_url . '/repos/'.$owner.'/'.$repository.'/branches';

        $response = $this->callAPI('GET', $url);

        if (!is_array($response)) {
            return null;
        }

        $all_commits = [];

        foreach($response as $branch) {
            //get all the commits of the specific branch
           if (!(array_key_exists('name', $branch) && array_key_exists('commit', $branch) && is_array($branch['commit']))) {
               return null;
           }

           $commits = $this->callAPI('GET', $branch['commit']['url']);

           if (!$commits) return null;

           $commitData = $this->validateBranchCommits($commits);

           if (!$commitData) return null;

           $currentCommit = new SingleCommitData($commitData['sha'], $commitData['message'], $commitData['name'], $commitData['email'], $commitData['date']);

           $all_commits[count($all_commits)] = $currentCommit;
        }

        if (count($all_commits) == 0) return null;

        return new CommitsData($all_commits);
    }

    public function fetchCommit(string $owner, string $repository, string $commit_sha): ?SingleCommitData
    {
        $url = $this->base_url . '/repos/'.$owner.'/'.$repository. '/commits/'.$commit_sha;

        $response = $this->callAPI('GET', $url);

        if (!is_array($response)) {
            return null;
        }

        $commitData = $this->validateBranchCommits($response);

        if (!$commitData) return null;

        $currentCommit = new SingleCommitData($commitData['sha'], $commitData['message'], $commitData['name'], $commitData['email'], $commitData['date']);

        if (!$currentCommit) return null;

        return $currentCommit;
    }

    public function getUser(string $owner): ?GithubUserAccount
    {
        $url = $this->base_url . '/users/'.$owner;

        $response = $this->callAPI('GET', $url);

        dd(['response' => $response]);
    }

    private function callAPI(string $method, string $url, ?array $content=[]): ?array
    {
        $head = [
            'content-type' => 'application/json',
            'accept' => 'application/json',
            'authorization' => 'token ' . $this->accessToken,
        ];

        if ($method == 'GET') {
            if (!(is_array($content) && count($content) > 0)) {
                $response = Http::withHeaders($head)->get($url);
            } else {
                $response = Http::withHeaders($head)->get($url, $content);
            }
        } else {
            if (!(is_array($content) && count($content) > 0)) {
                $response = Http::withHeaders($head)->post($url);
            } else {
                $response = Http::withHeaders($head)->post($url, $content);
            }
        }

        try {
            $jsonResponse = $response->throw()->json();

            Log::debug("::GITHUB_COMMITS_API:: Response", [
                'response' => (array) $jsonResponse,
            ]);

            return (array) $jsonResponse;
        } catch(\Exception|\Throwable $e) {
            Log::error("::GITHUB_COMMITS_API:: Error ", [
                'endpoint' => $url,
                'content' => $content,
                'error' => $e->getMessage(),
            ]);
        }

        return null;
    }

    private function validateBranchCommits(array $commits): ?array
    {
        //important data is the commit, having an author, message, url
        if (!(array_key_exists('sha', $commits) && array_key_exists('commit', $commits)
            && is_array(($specific_commit = $commits['commit'])) )) {
            return null;
        }

        if (!(array_key_exists('author', $specific_commit) && array_key_exists('message', $specific_commit))) {
            return null;
        }

        return [
            'name' => $specific_commit['author']['name'],
            'email' => $specific_commit['author']['email'],
            'date' => $specific_commit['author']['date'],
            'message' => $specific_commit['message'],
            'sha' => $commits['sha'],
        ];
    }
}
