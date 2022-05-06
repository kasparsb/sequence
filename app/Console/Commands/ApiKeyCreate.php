<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use \App\Models\User;

use ApiKeys;

class ApiKeyCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apikey:create {user_id} {description?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Veidojam api key';

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
        
        $user = User::find($this->argument('user_id'));
        if ($user) {
            
            $this->info('User: '.$user->email);

            $key = ApiKeys::create($user, $this->argument('description'));

            if ($key) {
                $this->info('apikey '.$key->key);
            }
            else {
                $this->error('cant create key');
            }
            
        }
    }
}
