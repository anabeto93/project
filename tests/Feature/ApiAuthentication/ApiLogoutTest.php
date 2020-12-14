<?php


namespace Tests\Feature\ApiAuthentication;


class ApiLogoutTest extends BaseAPIAuthenticationTest
{
    /**
     * @test
     * @group api
     */
    public function only_authenticated_users_can_logout()
    {
        $credentials = [
            'email' => $this->validEmail,
            'password' => $this->validPassword,
        ];

        $response = $this->postJson($this->logoutRoute, $credentials);

        $response->assertStatus(401);

        $response->assertJsonStructure([
            'status', 'reason',
        ]);
    }

    /**
     * @test
     * @group api
     */
    public function authenticated_user_can_logout()
    {
        $user = $this->createUser();

        //first login the user
        $token = $this->authenticateUser();

        $response = $this->postJson($this->logoutRoute, [], [
            'Authorization' => 'Bearer '. $token,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status', 'reason',
        ]);
    }
}
