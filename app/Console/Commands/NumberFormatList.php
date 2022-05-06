<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use \App\Models\NumberFormat;

use Numbers;

class NumberFormatList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'numberformat:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List number formats';

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
        $formats = NumberFormat::with('user')->get()->map(function($format){
            return [
                'id' => $format->id,
                'format' => $format->format,
                'user_id' => $format->user->id,
                'email' => $format->user->email,
            ];
        });

        $this->table(['id', 'format', 'user_id', 'email'], $formats);
    }
}
