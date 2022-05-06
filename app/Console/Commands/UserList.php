<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use \App\Models\User;

class UserList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all users';

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
        $users = User::get()->map(function($user){
            return [
                'id' => $user->id,
                'email' => $user->email,
            ];
        });

        $this->table(['id', 'email'], $users);
    }
}
