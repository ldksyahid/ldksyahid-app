<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunMachineLearning extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:svm-machine';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the machine learning code';

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
        $pythonOutput = shell_exec("python svm-machine.py");
        $this->info($pythonOutput);
    }
}
