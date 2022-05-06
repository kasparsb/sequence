<?php namespace App\Extensions;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

use \App\Models\ApiKey;

class ApiKeyProvider implements UserProvider {

    public function retrieveById($identifier) {
        
    }

    public function retrieveByToken($identifier, $token) {
        
    }

    public function updateRememberToken(Authenticatable $user, $token) {

    }

    public function retrieveByCredentials(array $credentials) {
        /**
         * Ir uztaisīts, ka šis \App\ApiKey
         * implemento šo Illuminate\Contracts\Auth\Authenticatable;
         */

        $r = ApiKey::with('user')->where('key', '=', $credentials['api_token'])->first();

        return $r;
    }

    public function validateCredentials(Authenticatable $user, array $credentials) {

    }
}