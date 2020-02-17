<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAmountAndPaydayToPriceAndPayDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incomes', function (Blueprint $table) {
            // droping columns
            $table->dropColumn("amount");
            $table->dropColumn("payday");

            // creating new columns
            $table->double('price', 10, 2)->after("name");
            $table->dateTime('pay_date')->nullable()->after("pay_schedule");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incomes', function (Blueprint $table) {
            //taking it all back
            $table->dropColumn("price");
            $table->dropColumn("pay_date");

            $table->dateTime('payday')->nullable()->after("pay_schedule");
            $table->double('amount', 10, 2)->after("name");
        });
    }
}
