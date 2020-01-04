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
        "user", "name", "amount", "steady", "pay_schedule", "payday", "tax", "description",
    ];

    /**
     * Relashionship
     */

    //  belongs to
    public function user()
    {
        return $this->belongsTo('App\User', 'user');
    }


    /**
     * validation
     * 
     * @param int user
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
     * @param array params
     * @return Income income
     */
    public function add($params)
    {
        return Income::create([
            "user" => $params['user'],
            "name" => $params['name'],
            "amount" => $params['amount'],
            "steady" => $params['steady'] ?? false,
            "pay_schedule" => $params['pay_schedule'] ?? null,
            "payday" => $params['payday'] ?? null,
            "tax" => $params['tax'] ?? 0,
            "description" => $params['description'] ?? null,
        ]);
    }

    /**
     * edit an income
     * 
     * @param int id
     * @param array params
     * @return Income income
     */
    public function edit($id, $params)
    {
        return Income::where("id", $id)->update([
            "user" => $params['user'],
            "name" => $params['name'],
            "amount" => $params['amount'],
            "steady" => $params['steady'] ?? false,
            "pay_schedule" => $params['pay_schedule'] ?? null,
            "payday" => $params['payday'] ?? null,
            "tax" => $params['tax'] ?? 0,
            "description" => $params['description'] ?? null,
        ]);
    }

    /**
     * softdelete an Income
     * 
     * @param int id
     */
    public function softDelete($id)
    {
        return Income::where("id", $id)->delete();
    }

    /**
     * harddelete an income
     * 
     * @param int id
     */
    public function hardDelete($id)
    {
        return Income::where("id", $id)->forceDelete();
    }

    /**
     * Quering
     */

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
        // day income
        if(isset($day) && $day){
            if(isset($limit) && $limit){
                return Income::where("user", $user)
                        ->whereDay('created_at', $day)
                        ->paginate($limit);
            }
            return Income::where("user", $user)
                    ->whereDay('created_at', $day)
                    ->get();
        }

        // month income
        if(isset($month) && $month){
            if(isset($limit) && $limit){
                return Income::where("user", $user)
                        ->whereMonth('created_at', $month)
                        ->paginate($limit);
            }
            return Income::where("user", $user)
                    ->whereMonth('created_at', $month)
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
