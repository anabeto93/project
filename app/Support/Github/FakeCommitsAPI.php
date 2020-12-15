<?php


namespace App\Support\Github;


use App\DTOs\CommitsData;
use App\DTOs\GithubUserAccount;
use App\DTOs\SingleCommitData;

class FakeCommitsAPI implements CommitsAPI
{
    public function fetchAll(string $owner, string $repository): ?CommitsData
    {
        $fakes = [];

        for($i = 0; $i < 5; ++$i) {
            $fakes[$i] = new SingleCommitData('12935e6770679d2ef0d6cba5496fc759424918d6', 'Fake commit message', 'Test User', 'test@github.com', now()->toIso8601String());
        }

        return new CommitsData($fakes);
    }

    public function fetchCommit(string $owner, string $repository, string $commit_sha): ?SingleCommitData
    {
        return new SingleCommitData('12935e6770679d2ef0d6cba5496fc759424918d6', 'Fake commit message', 'Test User', 'test@github.com', now()->toIso8601String());
    }

    public function getUser(string $owner): ?GithubUserAccount
    {
        return new GithubUserAccount(
            'https://avatars3.githubusercontent.com/u/7607657?v=4',
            'https://humvite.com', 'Richard Anabeto Opoku','richard@freshinup.com',
            'anabeto93'
        );
    }
}
