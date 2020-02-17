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
}
