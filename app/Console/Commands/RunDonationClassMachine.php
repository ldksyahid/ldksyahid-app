<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunDonationClassMachine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:donation-class-machine';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the machine learning MsDonation code';

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
     * @return int
     */
    public function handle()
    {
        $pythonOutput = shell_exec("python public/machine-learning/models/donation-class-machine.py");
        $this->info($pythonOutput);
    }
}
