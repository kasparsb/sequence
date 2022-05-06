<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use \App\Models\NumberFormat;
use \App\Models\User;

use Numbers;

class NumberCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'number:create {number_format_id} {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Veidojam jaunu numuru ar norādīto numura formātu';

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
        $numberFormat = NumberFormat::find($this->argument('number_format_id'));
        $user = User::find($this->argument('user_id'));
        if ($numberFormat && $user) {
            
            $this->info('Numura formats: '.$numberFormat->format);
            $this->info('User: '.$user->email);

            $number = Numbers::create($numberFormat, $user);

            $this->info('Counter: '.$number->counter);
            $this->info('Number: '.$number->number);
        }
    }
}
