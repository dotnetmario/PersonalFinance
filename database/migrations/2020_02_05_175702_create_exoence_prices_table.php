<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExoencePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expence_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('expence');
            $table->double('price', 10, 2);
            $table->boolean("active")->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('expence')->references('id')->on('expences')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expence_prices');
    }
}
