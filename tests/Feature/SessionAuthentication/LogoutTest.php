<?php


namespace Tests\Feature\SessionAuthentication;


use App\Models\User;

class LogoutTest extends BaseAuthenticationTestCase
{
    /** @test */
    public function userCanLogout()
    {
        $user = $this->createUser();

        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->postJson($this->logoutRoute);

        $response->assertStatus(204);
        $this->assertGuest();
    }
}
