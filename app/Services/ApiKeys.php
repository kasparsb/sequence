<?php namespace App\Services;

use \App\Models\ApiKey;

use Numbers;

class ApiKeys {

    private $generateTries = 0;

    public function create($user, $description=null) {
        $key = Numbers::format('{random40:a-z;0-9}');

        $apiKey = null;
        $done = false;
        while (!$done) {
            try {

                $apiKey = ApiKey::create([
                    'key' => $key,
                    'user_id' => $user->id,
                    'description' => $description
                ]);

                $done = true;

            } catch (\Illuminate\Database\QueryException $e) {

                if ($this->generateTries > 1000) {
                    abort(500, 'Can not generate api key');
                }

                $this->generateTries++;
            }
        }

        return $apiKey;
    }
}