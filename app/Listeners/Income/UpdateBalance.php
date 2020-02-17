<?php

namespace App\Listeners\Income;

use App\Events\IncomeTransaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Balance;

class UpdateBalance
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  IncomeTransaction  $event
     * @return void
     */
    public function handle(IncomeTransaction $event)
    {
        $trans = $event->income_tran;

        $balance = (new Balance)->updateBalance("income", $trans->id);
    }
}
