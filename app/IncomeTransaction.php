<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Income;
use App\Helper;

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
     * validation
     */
    
    /**
     * return true if the user is owner of the income
     * 
     * @param int income
     * @param int user
     * @return boolean
     */
    public static function canAddTrans($user, $income)
    {
        return $user == Income::find($income)->user;
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
        return $user == IncomeTransaction::find($trans)->income()->first()->user;
    }


    /**
     * make valid reference
     * 
     * @return string
     */
    public static function makeRef(){
        do{
            $ref = substr(md5(uniqid(time(), true)), 0, 20);
        }while(IncomeTransaction::where('ref', $ref)->get()->count() != 0);

        return $ref;
    }
    
    /**
     * CRUD
     */

    /**
     * add income transaction
     * 
     * @param array params
     * @return IncomeTransaction
     */
    public function add($params)
    {
        // make reference
        $ref = IncomeTransaction::makeRef();

        return IncomeTransaction::create([
            "ref" => $ref,
            "income" => $params['income'],
            "price" => $params['price']
        ]);
    }

    /**
     * update income transaction
     * 
     * @param array params
     * @return boolean
     */
    public function edit($params)
    {
        return IncomeTransaction::where('id', $params['income_t'])
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
        if(Helper::getStringType($params['income_t']) == "string"){
            $col = "ref";
        }
        return IncomeTransaction::where($col, $params['income_t'])->delete();
    }

    /**
     * harddelete an income price
     * 
     * @param array params
     * @return boolean
     */
    public function hardDelete($params)
    {
        $col = "id";
        if(Helper::getStringType($params['income_t']) == "string"){
            $col = "ref";
        }
        return IncomeTransaction::where($col, $params['income_t'])->forceDelete();
    }

    /**
     * Quering
     */

    /**
     * get transaction by id or ref
     * 
     * @param int id
     * @param string ref
     * @return IncomeTransaction
     */
    public function transaction($id, $ref = null){
        $t = null;
        // using reference
        if(isset($ref) && $ref != null){
            $t = IncomeTransaction::where('ref', $ref)->first();
        }

        // using id
        if(isset($id) && $id != null){
            $t = IncomeTransaction::where('id', $id)->first();
        }

        return empty($t) ? 0 : $t;
    }

    /**
     * get income transactions
     * 
     * @param int income
     * @return Collection
     */
    public function transactions($income)
    {
        $ts = null;

        $ts = IncomeTransaction::where('income', $income)->get();

        return empty($ts) ? 0 : $ts;
    }
}
