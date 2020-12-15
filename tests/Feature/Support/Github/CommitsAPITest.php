<?php


namespace Tests\Feature\Support\Github;

use App\DTOs\GithubUserAccount;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\DTOs\CommitsData;
use App\Support\Github\CommitsAPI;

class CommitsAPITest extends TestCase
{
    /** @test
     * @group github
     */
    public function can_fetch_commits_data_from_github()
    {
        $data = app(CommitsAPI::class)->fetchAll('owner', 'repo');

        $this->assertInstanceOf(CommitsData::class, $data);
    }

    /**
     * @test
     * @group github
     */
    public function can_fetch_user_profile_details_from_github()
    {
        $data = app(CommitsAPI::class)->getUser('anabeto93');

        $this->assertInstanceOf(GithubUserAccount::class, $data);
    }
}
