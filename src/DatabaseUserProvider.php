<?php namespace Bronco\LaravelDatabaseUserProvider;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class DatabaseUserProvider implements UserProvider{
    protected $username;
    protected $password;

    public function retrieveById($identifier) {
        $this->setDatabaseCredentials();

        $class = config('auth.providers.users.model');
        return $class::find($identifier);
    }

    public function retrieveByToken($identifier, $token) {

    }

    public function updateRememberToken(Authenticatable $user, $token) {

    }

    public function retrieveByCredentials(array $credentials) {
        $this->username = $credentials['username'];
        $this->password = $credentials['password'];

        $this->setDatabaseCredentials();

        $class = config('auth.providers.users.model');

        try {
            return $class::where('username', $credentials['email'])->first();
        } catch (\Illuminate\Database\QueryException $e) {
            return new $class;
        }
    }

    public function validateCredentials(Authenticatable $user, array $credentials) {
        return isset($user->username);
    }

    private function setDatabaseCredentials() {
        $defaultDriver = config('database.default');
        config(["database.connections.$defaultDriver.username" => $this->username ]);
        config(["database.connections.$defaultDriver.password" => $this->password ]);
    }

}
