<?php namespace Bronco\LaravelDatabaseUserProvider;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

use Bronco\LaravelDatabaseUserProvider\DatabaseUserProvider;

class DatabaseUserServiceProvider extends AuthServiceProvider
{
    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('databaseuser', function ($app, array $config) {
            return new DatabaseUserProvider($app->make('databaseuser.connection'));
        });
    }
}
