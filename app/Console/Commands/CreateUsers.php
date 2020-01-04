<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
// use App\User;

class CreateUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:generate {ppp}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create users accounts you can add the number of the users';

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
        // $drip->send(User::find($this->argument('user')));
        // $count = null;
        // if($this->argument('count') != null){
            // $count = $this->argument('ppp') ?? 10;
        // }

        factory("App\User", 10)->create();

        $this->info('Display this on the screen');
    }
}
