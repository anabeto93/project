<?php


namespace Tests\Feature\SessionAuthentication;

use App\Models\User;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Cookie;

class LoginTest extends BaseAuthenticationTestCase
{
    /** @test */
    public function cannotLoginWithWrongEmail()
    {
        $this->attemptLoginAndExpectFail([
            'email' => $this->invalidEmail,
        ], 'email');
    }

    /** @test */
    public function cannotLoginWithWrongPassword()
    {
        $this->attemptLoginAndExpectFail([
            'password' => $this->invalidPassword,
        ], 'email');
    }

    /** @test */
    public function cookieGetsSetIfRememberMeIsChecked()
    {
        $response = $this->attemptLogin([
            'email' => $this->validEmail,
            'password' => $this->validPassword,
            'remember' => 'on',
        ]);

        $response->assertCookie(Auth::guard()->getRecallerName(), "{$response->user->id}|{$response->user->getRememberToken()}|{$response->user->getAuthPassword()}");
    }

    protected function attemptLoginAndExpectFail(array $params, string $fieldWithError, int $status = 422)
    {
        $response = $this->attemptLogin($params);

        $response->assertStatus($status);
        $response->assertJsonValidationErrors($fieldWithError);
        $this->assertGuest();

        return $response;
    }

    protected function attemptLogin($params = [])
    {
        $this->enableCsrfProtection();

        $user = User::whereEmail($this->validEmail)->first();

        if (! $user) {
            $user = $this->createUser();
        }

        $this->withHeader('X-XSRF-TOKEN', $this->getXsrfTokenFromResponse($this->fetchXsrfToken()));

        $default_credentials = [
            'email' => $this->validEmail,
            'password' => $this->validPassword,
        ];

        $credentials = array_merge($default_credentials, $params);

        $response = $this->postJson($this->loginRoute, $credentials);
//dd(['login_response' => $response->json()]);
        $response->user = $user;

        return $response;
    }

    protected function fetchXsrfToken()
    {
        return $this->getJson(rtrim(config('sanctum.prefix', 'sanctum'), '/').'/csrf-cookie');
    }

    protected function getXsrfTokenFromResponse(TestResponse $response): string {
        $cookie = collect($response->headers->getCookies())->first(function (Cookie $cookie) {
            return $cookie->getName() === 'XSRF-TOKEN';
        });

        return $cookie ? $cookie->getValue() : '';
    }

    /** @test */
    public function passwordFieldIsRequired()
    {
        $this->attemptLoginAndExpectFail([
            'password' => '',
        ], 'password');
    }

    /** @test */
    public function emailFieldIsRequired()
    {
        $this->attemptLoginAndExpectFail([
            'email' => '',
        ], 'email');
    }

    /** @test */
    public function guestCanLoginWithCorrectCredentials()
    {
        $response = $this->attemptLogin([
            'email' => $this->validEmail,
            'password' => $this->validPassword,
        ]);

        $response->assertStatus(204);
        $this->assertAuthenticatedAs($response->user);
    }

    /** @test */
    public function nonExistentUserCannotLogin()
    {
        $this->attemptLoginAndExpectFail([
            'email' => 'not-registered@example.com',
            'password' => 'password',
        ], 'email');
    }

    /** @test */
    public function sanctumRouteSetsXsrfTokenCookie()
    {
        $response = $this->fetchXsrfToken();

        $response->assertStatus(204);
        $response->assertCookie('XSRF-TOKEN', Session::get('_token'));
    }
}
