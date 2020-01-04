<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateIncomes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'incomes:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates incomes';

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
        factory("App\Income", 1200)->create();

        $this->info('Display this on the screen');
    }
}
