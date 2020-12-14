<?php


namespace Tests\Feature\ApiAuthentication;


class ApiLoginTest extends BaseAPIAuthenticationTest
{
    /**
     * @test
     * @group api
     */
    public function valid_user_can_get_jwt_token()
    {
        $user = $this->createUser();

        $credentials = [
            'email' => $this->validEmail,
            'password' => $this->validPassword,
        ];

        $response = $this->postJson($this->loginRoute, $credentials);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status', 'reason', 'data' => [
                'token', 'type', 'ttl'
            ],
        ]);
    }

    /**
     * @test
     * @group api
     */
    public function valid_user_with_wrong_credentials_cannot_authenticate()
    {

        $user = $this->createUser();

        $credentials = [
            'email' => $this->validEmail,
            'password' => 'some_wrong_password',
        ];

        $response = $this->postJson($this->loginRoute, $credentials);

        $response->assertStatus(401);

        $response->assertJsonStructure([
            'status', 'reason',
        ]);
    }

    /**
     * @test
     * @group api
     */
    public function non_existent_user_cannot_authenticate()
    {
        $credentials = [
            'email' => $this->validEmail,
            'password' => $this->validPassword,
        ];

        $response = $this->postJson($this->loginRoute, $credentials);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'status', 'reason', 'data',
        ]);
    }

}
