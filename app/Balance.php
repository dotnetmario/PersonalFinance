<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// models
use App\IncomeTransaction;
use App\ExpenceTransaction;

class Balance extends Model
{
    // soft deletes
    use SoftDeletes;

    protected $table = "balances";

    protected $fillable = [
        "balance", "user", "last_income_trans", "last_expence_trans",
    ];

    /**
     * Relashionship
     */

    //  belongs to
    public function user()
    {
        return $this->hasOne('App\User', 'user');
    }


    /**
     * update a users balance
     * 
     * @param string type
     * @param int trans
     */
    public function updateBalance($type, $trans_id){
        if($type = "income"){
            $transaction = new IncomeTransaction;
            $transaction = $transaction->transaction($trans_id);

            $income = $transaction->income()->first();
            $price = $income->prices()->where('active', 1)->orderBy('id', 'DESC')->first();
            $user = $income->user()->first();

            $balance = Balance::where('user', $user->id)->first();
            $balance->last_income_trans = $trans_id;
            $balance->balance += $transaction->price;
            $balance->save();

            return $balance;
        }else if($type = "expence"){
            $transaction = new ExpenceTransaction;
            $transaction = $transaction->transaction($trans_id);

            $expence = $transaction->expence()->first();
            $price = $expence->prices()->where('active', 1)->orderBy('id', 'DESC')->first();
            $user = $expence->user()->first();

            $balance = Balance::where('user', $user->id)->first();
            $balance->last_expence_trans = $trans_id;
            $balance->balance -= $transaction->price;
            $balance->save();

            return $balance;
        }
    }
}
