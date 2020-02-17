<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

use App\Mail\TransactionMade;
use App\IncomeTransaction;
use App\ExpenceTransaction;

class Emailer extends Model
{
    /**
     * sends email to notify when a transaction is made
     * 
     * @param string type
     * @param Object trans
     */
    public function transactionMade($type, $trans){
        if($type == "income"){
            $income = $trans->income()->first();
            $user = $income->user()->first();
        }else if($type == "expence"){
            $expence = $trans->expence()->first();
            $user = $expence->user()->first();
        }

        Mail::to($user)->send(new TransactionMade($type, $trans));
    }
}
