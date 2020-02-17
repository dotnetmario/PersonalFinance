<?php

namespace App\Listeners\Expence;

use App\Events\ExpenceTransaction;
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
     * @param  ExpenceTransaction  $event
     * @return void
     */
    public function handle(ExpenceTransaction $event)
    {
        $trans = $event->expence_tran;

        $balance = (new Balance)->updateBalance("expence", $trans->id);
    }
}
