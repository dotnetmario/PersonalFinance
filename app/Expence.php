<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expence extends Model
{
    // soft deletes
    use SoftDeletes;

    protected $table = "expences";

    protected $fillable = [
        "user", "name", "steady", "pay_schedule", "pay_date", "tax", "description",
    ];

    /**
     * Relashionship
     */

    //  belongs to
    // user owner of the expence
    public function user()
    {
        return $this->belongsTo('App\User', 'user');
    }

    // has many transactions
    public function transactions()
    {
        return $this->hasMany('App\ExpenceTransaction', 'expence');
    }

    // has many prices
    public function prices()
    {
        return $this->hasMany('App\ExpencePrice', 'expence');
    }


    /**
     * validation if user is owner of the expence
     * 
     * @param int user
     * @param int expence
     * @return boolean
     */
    public static function canModify($user, $expence){
        return $user == Expence::find($expence)->user;
    }

    /**
     * CRUD
     */

    /**
     * add a new expence
     * 
     * @param int user
     * @param array params
     * @return Expence expence
     */
    public function add($user, $params)
    {
        return Expence::create([
            "user" => $user,
            "name" => $params['name'],
            "steady" => $params['steady'] ?? false,
            "pay_schedule" => $params['pay_schedule'] ?? null,
            "pay_date" => $params['pay_date'] ?? null,
            "tax" => $params['tax'] ?? 0,
            "description" => $params['description'] ?? null,
        ]);
    }

    /**
     * edit an expence
     * 
     * @param int id
     * @param array params
     * @return boolean
     */
    public function edit($id, $params)
    {
        return Expence::where("id", $id)->update([
            "name" => $params['name'],
            "steady" => $params['steady'] ?? false,
            "pay_schedule" => $params['pay_schedule'] ?? null,
            "pay_date" => $params['pay_date'] ?? null,
            "tax" => $params['tax'] ?? 0,
            "description" => $params['description'] ?? null,
        ]);
    }

    /**
     * softdelete an Expence
     * 
     * @param int id
     * @return boolean
     */
    public function softDelete($id)
    {
        return Expence::where("id", $id)->delete();
    }

    /**
     * hard delete an Expence
     * 
     * @param int id
     * @return boolean
     */
    public function hardDelete($id)
    {
        return Expence::where("id", $id)->forceDelete();
    }

    /**
     * Quering
     */

     /**
      * get expence by id
      * 
      * @param int expence
      * @return Expence
      */
    public function expence($expence)
    {
        $i = Expence::find($expence);
        return empty($i) ? 0 : $i;
    }
  
  
    /**
     * get users Expences with or without pagination
     * 
     * @param int user
     * @param int limit
     */
    public function userExpences($user, $limit = null)
    {
        if(isset($limit) && $limit){
            return Expence::where("user", $user)
                    ->orderBy("created_at", "DESC")
                    ->paginate($limit);
        }

        return Expence::where("user", $user)
                ->orderBy("created_at", "DESC")
                ->get();
    }
  
    /**
     * get users day/month/year expences with or without pagination
     * 
     * @param int user
     * @param int day
     * @param int month
     * @param int year
     * @param int limit
     */
    public function userExpenceDate($user, $params)
    {
        $day = $params["day"] ?? null; $month = $params["month"] ?? null; $year = $params["year"] ?? null; $limit = $params["limit"] ?? null;

        if(isset($day) && $day){
            if(isset($limit) && $limit){
                return Expence::where("user", $user)
                        ->whereDay('created_at', $day)
                        ->whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->paginate($limit);
            }
            return Expence::where("user", $user)
                    ->whereDay('created_at', $day)
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->get();
        }

        // month expence
        if(isset($month) && $month){
            if(isset($limit) && $limit){
                return Expence::where("user", $user)
                        ->whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->paginate($limit);
            }
            return Expence::where("user", $user)
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->get();
        }

        // year expence
        if(isset($year) && $year){
            if(isset($limit) && $limit){
                return Expence::where("user", $user)
                        ->whereYear('created_at', $year)
                        ->paginate($limit);
            }
            return Expence::where("user", $user)
                    ->whereYear('created_at', $year)
                    ->get();
        }

        return false;
    }
}
