<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenceTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expence_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ref')->unique();
            $table->unsignedBigInteger('expence');
            $table->double('price', 10, 2);
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
        Schema::dropIfExists('expence_transactions');
    }
}
