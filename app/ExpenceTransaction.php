<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenceTransaction extends Model
{
    // soft deletes
    use SoftDeletes;

    protected $table = "expence_transactions";

    protected $fillable = [
        "expence", "price", "ref",
    ];

    /**
     * Relashionship
     */

    //  belongs to
    public function expence()
    {
        return $this->belongsTo('App\Expence', 'expence');
    }

    //  belongs to
    public function balance()
    {
        return $this->hasOne('App\Balance', 'last_expence_trans');
    }

    /**
     * make valid reference
     * 
     * @return string
     */
    public static function makeRef(){
        do{
            $ref = substr(md5(uniqid(rand(), true)), 0, 20);
        }while(ExpenceTransaction::where('ref', $ref)->get()->count() != 0);

        return $ref;
    }

    /**
     * get transaction by id or ref
     * 
     * @param int id
     * @param string ref
     * @return ExpenceTransaction
     */
    public function transaction($id, $ref = null){
        // using reference
        if(isset($ref) && $ref != null){
            return ExpenceTransaction::where('ref', $ref)->first();
        }

        // using id
        if(isset($id) && $id != null){
            return ExpenceTransaction::where('id', $id)->first();
        }

        return null;
    }
}
