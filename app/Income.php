<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    // soft deletes
    use SoftDeletes;

    protected $table = "incomes";

    protected $fillable = [
        "user", "name", "steady", "pay_schedule", "pay_date", "tax", "description",
    ];

    /**
     * Relashionship
     */

    //  belongs to
    // user owner of the income
    public function user()
    {
        return $this->belongsTo('App\User', 'user');
    }

    // has many transactions
    public function transactions()
    {
        return $this->hasMany('App\IncomeTransaction', 'income');
    }

    // has many prices
    public function prices()
    {
        return $this->hasMany('App\IncomePrice', 'income');
    }


    /**
     * validation
     * 
     * @param int user
     * @param int income
     * @return boolean
     */
    public static function canModify($user, $income){
        return $user == Income::find($income)->user;
    }

    /**
     * CRUD
     */

    /**
     * add a new income
     * 
     * @param int user
     * @param array params
     * @return Income income
     */
    public function add($user, $params)
    {
        return Income::create([
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
     * edit an income
     * 
     * @param int id
     * @param array params
     * @return boolean
     */
    public function edit($id, $params)
    {
        return Income::where("id", $id)->update([
            "name" => $params['name'],
            "steady" => $params['steady'] ?? false,
            "pay_schedule" => $params['pay_schedule'] ?? null,
            "pay_date" => $params['pay_date'] ?? null,
            "tax" => $params['tax'] ?? 0,
            "description" => $params['description'] ?? null,
        ]);
    }

    /**
     * softdelete an Income
     * 
     * @param int id
     * @return boolean
     */
    public function softDelete($id)
    {
        return Income::where("id", $id)->delete();
    }

    /**
     * harddelete an income
     * 
     * @param int id
     * @return boolean
     */
    public function hardDelete($id)
    {
        return Income::where("id", $id)->forceDelete();
    }

    /**
     * Quering
     */

     /**
      * get income by id
      * 
      * @param int income
      * @return Income
      */
    public function income($income)
    {
        $i = Income::find($income);
        return empty($i) ? 0 : $i;
    }


    /**
     * get users Incomes with or without pagination
     * 
     * @param int user
     * @param int limit
     */
    public function userIncomes($user, $limit = null)
    {
        if(isset($limit) && $limit){
            return Income::where("user", $user)
                    ->orderBy("created_at", "DESC")
                    ->paginate($limit);
        }

        return Income::where("user", $user)
                ->orderBy("created_at", "DESC")
                ->get();
    }

    /**
     * get users day/month/year incomes with or without pagination
     * 
     * @param int user
     * @param int day
     * @param int month
     * @param int year
     * @param int limit
     */
    public function userIncomeDate($user, $params)
    {
        $day = $params["day"] ?? null; $month = $params["month"] ?? null; $year = $params["year"] ?? null; $limit = $params["limit"] ?? null;

        if(isset($day) && $day){
            if(isset($limit) && $limit){
                return Income::where("user", $user)
                        ->whereDay('created_at', $day)
                        ->whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->paginate($limit);
            }
            return Income::where("user", $user)
                    ->whereDay('created_at', $day)
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->get();
        }

        // month income
        if(isset($month) && $month){
            if(isset($limit) && $limit){
                return Income::where("user", $user)
                        ->whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->paginate($limit);
            }
            return Income::where("user", $user)
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->get();
        }

        // year income
        if(isset($year) && $year){
            if(isset($limit) && $limit){
                return Income::where("user", $user)
                        ->whereYear('created_at', $year)
                        ->paginate($limit);
            }
            return Income::where("user", $user)
                    ->whereYear('created_at', $year)
                    ->get();
        }

        return false;
    }
}
