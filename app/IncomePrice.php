<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Income;

class IncomePrice extends Model
{
    // soft deletes
    use SoftDeletes;

    protected $table = "income_prices";

    protected $fillable = [
        "income", "price", "active",
    ];

    /**
     * Relashionship
     */

    //  belongs to
    public function income()
    {
        return $this->belongsTo('App\Income', 'income');
    }

    /**
     * validation
     * 
     */

    /**
     * returns true if user owner of the income price
     * 
     * @param int user
     * @param int price
     * @return boolean
     */
    public static function canModify($user, $price)
    {
        return $user == IncomePrice::find($price)->income()->first()->user;
    }

    /**
     * returns true if the user is owner of the income
     * 
     * @param int income
     * @param int user
     * @return boolean
     */
    public static function canAddPrice($user, $income)
    {
        return $user == Income::find($income)->user;
    }


    /**
     * CRUD
     */

     /**
      * add a new income price
      *
      * @param array params
      * @return IncomePrice
      */
    public function add($params)
    {
        return IncomePrice::create([
            "income" => $params['income'],
            "price" => $params['price'],
            "active" => $params['active']
        ]);
    }

    /**
     * update income price
     * 
     * @param array params
     * @return boolean
     */
    public function edit($params)
    {
        return IncomePrice::where('id', $params['income_p'])->update([
            "price" => $params['price'],
            "active" => $params['active']
        ]);
    }

    /**
     * softdelete an Income price
     * 
     * @param int id
     * @return boolean
     */
    public function softDelete($id)
    {
        return IncomePrice::where("id", $id)->delete();
    }

    /**
     * harddelete an income price
     * 
     * @param int id
     * @return boolean
     */
    public function hardDelete($id)
    {
        return IncomePrice::where("id", $id)->forceDelete();
    }

    /**
     * Quering
     */

    /**
     * get income prices or one by id
     * 
     * @param int price
     * @return IncomePrice
     */
    public function prices($income = null, $price = null)
    {
        if(isset($price)){
            $p = IncomePrice::find($price);
            return empty($p) ? 0 : $p;
        }

        if(isset($income)){
            $ps = IncomePrice::where('income', $income)->get();
            return empty($ps) ? 0 : $ps;
        }

        return 0;
    }
}
