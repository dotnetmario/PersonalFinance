<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('income');
            $table->double('price', 10, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('income')->references('id')->on('incomes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('income_prices');
    }
}
