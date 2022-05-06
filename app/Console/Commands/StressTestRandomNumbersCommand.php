<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use \App\Models\User;

use Numbers;

class StressTestRandomNumbersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'number:stresstestrandom {number_format_id} {count?} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ģenerējam tik ilgi kamēr nevar vairs uzģenērēt jaunu numuru';

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
        if ($numberFormat = \App\NumberFormat::find($this->argument('number_format_id'))) {

            $this->info('Numura formats: '.$numberFormat->format);

            $count = $this->argument('count');

            // Ja negatīvs, tad neierobežots skaits
            $count = is_numeric($count) ? $count : -1;

            $user = User::find(1);

            $st = microtime(true);

            $counter = 1;
            while (1) {
                $number = Numbers::getNewNumber($numberFormat, $user, null);

                if ($number->generate_tries > 0) {
                    $this->warn($counter.' '.$number->generate_tries.' '.$number->number);
                    $this->info(microtime(true) - $st);
                    die();
                }
                else {
                    $this->info($counter.' '.$number->generate_tries.' '.$number->number);
                }


                $counter++;

                if ($count > 0) {
                    if ($count < $counter) {
                        break;
                    }
                }
            }

            $eta = microtime(true) - $st;

            var_dump($eta);

            // $this->info('Counter: '.$number->counter);
            // $this->info('Number: '.$number->number);
        }
    }
}