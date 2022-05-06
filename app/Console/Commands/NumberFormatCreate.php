<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use \App\Models\NumberFormat;

use Numbers;

class NumberFormatCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'numberformat:create {format} {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create number formats';

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
        $format = NumberFormat::create([
            'format' => $this->argument('format'),
            'user_id' => $this->argument('user_id'),
        ]);

        $this->info($format->id);
    }
}
