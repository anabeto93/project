<?php

namespace App\Providers;

use App\Support\Github\CommitsAPI;
use App\Support\Github\FakeCommitsAPI;
use App\Support\Github\GithubCommitsAPI;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CommitsAPI::class, function ($app) {
            if (app()->environment('testing')) {
                return app(FakeCommitsAPI::class);
            }

            return app(GithubCommitsAPI::class);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
