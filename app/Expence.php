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
}
