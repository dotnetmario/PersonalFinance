<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\IncomeTransaction;
use App\ExpenceTransaction;

class TransactionMade extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    public $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($type, $trans)
    {
        $this->type = $type;
        $this->transaction = $trans;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($type == "income"){
            $name = $this->transaction->income()->first()->name;
        }else{
            $name = $this->transaction->expence()->first()->name;
        }
        return $this->view('view.mail.transactionmade', compact("name"));
    }
}
