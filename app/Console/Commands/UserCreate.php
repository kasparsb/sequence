<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use \App\Models\User;

class UserCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Izveido lietotāju';

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
        if (User::where('email', '=', $this->argument('email'))->exists()) {
            $this->warn('User exists');
            return;
        }

        $user = User::create([
            'email' => $this->argument('email'),
        ]);

        $this->info($user->id);
    }
}
