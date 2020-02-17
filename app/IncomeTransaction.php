<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomeTransaction extends Model
{
    // soft deletes
    use SoftDeletes;

    protected $table = "income_transactions";

    protected $fillable = [
        "ref", "income", "price",
    ];

    /**
     * Relashionship
     */

    //  belongs to
    public function income()
    {
        return $this->belongsTo('App\Income', 'income');
    }

    //  belongs to
    public function balance()
    {
        return $this->hasOne('App\Balance', 'last_income_trans');
    }


    /**
     * make valid reference
     * 
     * @return string
     */
    public static function makeRef(){
        do{
            $ref = substr(md5(uniqid(rand(), true)), 0, 20);
        }while(IncomeTransaction::where('ref', $ref)->get()->count() != 0);

        return $ref;
    }
    
    /**
     * get transaction by id or ref
     * 
     * @param int id
     * @param string ref
     * @return IncomeTransaction
     */
    public function transaction($id, $ref = null){
        // using reference
        if(isset($ref) && $ref != null){
            return IncomeTransaction::where('ref', $ref)->first();
        }

        // using id
        if(isset($id) && $id != null){
            return IncomeTransaction::where('id', $id)->first();
        }

        return null;
    }
}
