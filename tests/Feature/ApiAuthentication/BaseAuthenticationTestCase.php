<?php

namespace Tests\Feature\ApiAuthentication;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BaseAuthenticationTestCase extends TestCase
{
    use RefreshDatabase;

    protected $invalidEmail = 'invalid@freshinup.com';

    protected $invalidPassword = 'invalid';

    protected $validEmail = 'john@freshinup.com';

    protected $validPassword = 'password';

    protected $loginRoute;

    protected $logoutRoute;

    protected function enableCsrfProtection()
    {
        // csrf is disabled when running tests, but we want to turn it on
        // just needs to be something other than 'testing'
        $this->app['env'] = 'development';
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->loginRoute = route('login');
        $this->logoutRoute = route('logout');
    }

    protected function createUser()
    {
        return User::factory()->create([
            'email' => $this->validEmail,
            'password' => Hash::make($this->validPassword),
        ]);
    }
}
