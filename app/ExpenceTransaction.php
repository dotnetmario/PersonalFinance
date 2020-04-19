<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Expence;

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
     * validation
     */
    
    /**
     * return true if the user is owner of the expence
     * 
     * @param int expence
     * @param int user
     * @return boolean
     */
    public static function canAddTrans($user, $expence)
    {
        return $user == Expence::find($expence)->user;
    }

    /**
     * return true if the user owner of the transaction
     * 
     * @param int user
     * @param int trans
     * @return boolean
     */
    public static function canModify($user, $trans)
    {
        return $user == ExpenceTransaction::find($trans)->expence()->first()->user;
    }

    /**
     * make valid reference
     * 
     * @return string
     */
    public static function makeRef(){
        do{
            $ref = substr(md5(uniqid(time(), true)), 0, 20);
        }while(ExpenceTransaction::where('ref', $ref)->get()->count() != 0);

        return $ref;
    }

    /**
     * CRUD
     */

    /**
     * add expence transaction
     * 
     * @param array params
     * @return ExpenceTransaction
     */
    public function add($params)
    {
        // make reference
        $ref = ExpenceTransaction::makeRef();

        return ExpenceTransaction::create([
            "ref" => $ref,
            "expence" => $params['expence'],
            "price" => $params['price']
        ]);
    }

    /**
     * update expence transaction
     * 
     * @param array params
     * @return boolean
     */
    public function edit($params)
    {
        return ExpenceTransaction::where('id', $params['expence_t'])
                ->update([
                    "price" => $params['price']
                ]);
    }

    /**
     * soft delete delete by id or reference
     * 
     * @param array params
     * @return boolean
     */
    public function softDelete($params)
    {
        $col = "id";
        if(Helper::getStringType($params['expence_t']) == "string"){
            $col = "ref";
        }
        return ExpenceTransaction::where($col, $params['expence_t'])->delete();
    }

    /**
     * harddelete an expence price
     * 
     * @param array params
     * @return boolean
     */
    public function hardDelete($params)
    {
        $col = "id";
        if(Helper::getStringType($params['expence_t']) == "string"){
            $col = "ref";
        }
        return ExpenceTransaction::where($col, $params['expence_t'])->forceDelete();
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

    /**
     * get expence transactions
     * 
     * @param int expence
     * @return Collection
     */
    public function transactions($expence)
    {
        $ts = null;

        $ts = ExpenceTransaction::where('expence', $expence)->get();

        return empty($ts) ? 0 : $ts;
    }
}
