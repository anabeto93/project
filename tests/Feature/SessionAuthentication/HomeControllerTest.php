<?php


namespace Tests\Feature\SessionAuthentication;


class HomeControllerTest extends BaseAuthenticationTestCase
{
    /** @test
     * @group dashboard
     */
    public function user_can_access_dashboard()
    {

        $user = $this->createUser();

        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->get('/');

        $response->assertSee('' . $user->name);
        $response->assertSee('Username');
        $response->assertSee('Repository Name');
    }

    /**
     * @test
     * @group dashboard
     */
    public function auth_user_can_fetch_commits_by_entering_username_and_repository()
    {

        $user = $this->createUser();
        $this->actingAs($user);

        $payload = [
            'github_username' => 'some_user',
            'repository' => 'valid_repository',
        ];

        $url = route('home'). '?' . http_build_query($payload);

        $response = $this->get($url);

        $response->assertSee('Richard Opoku');//from the fake commits api
        $response->assertSee('' . $user->name);
        $response->assertSee('Username');
        $response->assertSee('Repository Name');
    }
}
