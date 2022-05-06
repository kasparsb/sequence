<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use \App\Models\NumberFormat;
use \App\Models\ApiKey;

use Numbers;

class NumberCreateByApiKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'number:createbyapikey {number_format_id} {api_key}';

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
        
        $apiKey = ApiKey::with('user')->where('key', '=', $this->argument('api_key'))->first();

        if ($numberFormat && $apiKey) {
            
            $this->info('Numura formats: '.$numberFormat->format);
            $this->info('User: '.$apiKey->user->email);

            $number = Numbers::createByApiKey($numberFormat, $apiKey);

            $this->info('Counter: '.$number->counter);
            $this->info('Number: '.$number->number);
        }
    }
}
