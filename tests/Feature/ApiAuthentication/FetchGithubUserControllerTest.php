<?php


namespace ApiAuthentication;


use Tests\Feature\ApiAuthentication\BaseAPIAuthenticationTest;

class FetchGithubUserControllerTest extends BaseAPIAuthenticationTest
{
    /**
     * @test
     * @group github
     */
    public function unauthenticated_user_cannot_fetch_a_github_account_details()
    {
        $payload = [
            'github_username' => 'some_user',
        ];

        $url = route('api.github.user');

        $response = $this->getJson($url, $payload);

        $response->assertStatus(401);

        $response->assertJsonStructure([
            'status', 'reason',
        ]);
    }

    /**
     * @test
     * @group github
     */
    public function authenticated_user_can_fetch_github_user_account()
    {
        $user = $this->createUser();

        //first login the user
        $token = $this->authenticateUser();

        $payload = [
            'github_username' => 'some_user',
        ];

        $url = route('api.github.user', $payload);

        $response = $this->getJson($url, [
            'Authorization' => 'Bearer '. $token,
        ]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status', 'reason', 'data' => [
                'name', 'email', 'avatar'
            ],
        ]);
    }
}
