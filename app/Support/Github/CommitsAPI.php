<?php


namespace App\Support\Github;


use App\DTOs\CommitsData;
use App\DTOs\SingleCommitData;
use App\DTOs\GithubUserAccount;

interface CommitsAPI
{
    public function fetchAll(string $owner, string $repository): ?CommitsData;

    public function fetchCommit(string $owner, string $repository, string $commit_sha): ?SingleCommitData;

    public function getUser(string $owner): ?GithubUserAccount;
}
