<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Expence;

class ExpencePrice extends Model
{
    // soft deletes
    use SoftDeletes;

    protected $table = "expence_prices";

    protected $fillable = [
        "expence", "price", "active",
    ];

    /**
     * Relashionship
     */

    //  belongs to
    public function expence()
    {
        return $this->belongsTo('App\Expence', 'expence');
    }


    /**
     * validation
     * 
     */

    /**
     * returns true if user owner of the expence price
     * 
     * @param int user
     * @param int price
     * @return boolean
     */
    public static function canModify($user, $price)
    {
        return $user == ExpencePrice::find($price)->expence()->first()->user;
    }

    /**
     * returns true if the user is owner of the expence
     * 
     * @param int expence
     * @param int user
     * @return boolean
     */
    public static function canAddPrice($user, $expence)
    {
        return $user == Expence::find($expence)->user;
    }

    /**
     * CRUD
     */

     /**
      * add a new expence price
      *
      * @param array params
      * @return ExpencePrice
      */
    public function add($params)
    {
        return ExpencePrice::create([
            "expence" => $params['expence'],
            "price" => $params['price'],
            "active" => $params['active']
        ]);
    }

    /**
     * update expence price
     * 
     * @param array params
     * @return boolean
     */
    public function edit($params)
    {
        return ExpencePrice::where('id', $params['expence_p'])->update([
            "price" => $params['price'],
            "active" => $params['active']
        ]);
    }

    /**
     * softdelete an Expence price
     * 
     * @param int id
     * @return boolean
     */
    public function softDelete($id)
    {
        return ExpencePrice::where("id", $id)->delete();
    }

    /**
     * harddelete an expence price
     * 
     * @param int id
     * @return boolean
     */
    public function hardDelete($id)
    {
        return ExpencePrice::where("id", $id)->forceDelete();
    }

    /**
     * Quering
     */

    /**
     * get expence prices or one by id
     * 
     * @param int price
     * @return ExpencePrice
     */
    public function prices($expence = null, $price = null)
    {
        if(isset($price)){
            $p = ExpencePrice::find($price);
            return empty($p) ? 0 : $p;
        }

        if(isset($expence)){
            $ps = ExpencePrice::where('expence', $expence)->get();
            return empty($ps) ? 0 : $ps;
        }

        return 0;
    }
}
