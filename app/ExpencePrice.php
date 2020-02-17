<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
