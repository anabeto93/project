<?php


namespace ApiAuthentication;


use Tests\Feature\ApiAuthentication\BaseAPIAuthenticationTest;

class FetchGithubRepositoryCommitsTest extends BaseAPIAuthenticationTest
{

    /**
     * @test
     * @group github
     */
    public function unauthenticated_user_cannot_fetch_a_github_repository_commits()
    {
        $payload = [
            'github_username' => 'some_user',
        ];

        $url = route('api.github.commits');

        $response = $this->getJson($url, $payload);

        $response->assertStatus(401);

        $response->assertJsonStructure([
            'status', 'reason',
        ]);
    }

    public function missingFieldsDataProvider()
    {
        $data = [
            'github_username' => 'me',
            'repository' => 'some_repository',
        ];

        $final = [];

        $keys = ['github_username', 'repository'];

        foreach($keys as $key) {
            $temp = $data;

            unset($temp[$key]);

            $final['Missing '.ucfirst($key)] = [$temp];
        }

        return $final;
    }

    /**
     * @test
     * @group github
     * @dataProvider missingFieldsDataProvider
     */
    public function missing_fields_will_cause_github_commits_api_request_to_fail(array $formData)
    {
        $user = $this->createUser();

        //first login the user
        $token = $this->authenticateUser();

        $url = route('api.github.commits') .'?'. http_build_query($formData);

        $response = $this->getJson($url, [
            'Authorization' => 'Bearer '. $token,
        ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'status', 'reason',
        ]);
    }

    /**
     * @test
     * @group github
     */
    public function authenticated_user_can_fetch_github_repository_commits()
    {
        $user = $this->createUser();

        //first login the user
        $token = $this->authenticateUser();

        $payload = [
            'github_username' => 'some_user',
            'repository' => 'valid_repository',
        ];

        $url = route('api.github.commits') .'?'. http_build_query($payload);

        $response = $this->getJson($url, [
            'Authorization' => 'Bearer '. $token,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status', 'reason', 'data' => [
                'commits',
            ],
        ]);
    }
}
