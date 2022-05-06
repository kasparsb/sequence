<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use \App\Models\ApiKey;

use ApiKeys;

class ApiKeyList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apikey:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List Api keys';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $keys = ApiKey::with('user')->get()->map(function($key){
            return [
                'key' => $key->key,
                'description' => $key->description,
                'user_id' => $key->user->id,
                'email' => $key->user->email,
            ];
        });

        $this->table(['key', 'description', 'user_id', 'email'], $keys);
    }
}
