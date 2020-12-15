<?php


namespace Tests\Feature\ApiAuthentication;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BaseAPIAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected string $validEmail = 'john@freshinup.com';

    protected string $validPassword = 'password';

    protected $loginRoute;

    protected $logoutRoute;

    protected function setUp(): void
    {
        parent::setUp();
        $this->loginRoute = route('api.login');
        $this->logoutRoute = route('api.logout');
    }

    protected function createUser()
    {
        return User::factory()->create([
            'email' => $this->validEmail,
            'password' => Hash::make($this->validPassword),
        ]);
    }

    protected function authenticateUser(array $params=[])
    {
        $default = [
            'email' => $this->validEmail,
            'password' => $this->validPassword,
        ];

        $credentials = array_merge($default, $params);

        $response = $this->postJson($this->loginRoute, $credentials);

        return $response->json('data.token');
    }
}
