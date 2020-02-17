<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
