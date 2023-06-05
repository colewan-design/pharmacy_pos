<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id("transactionId");
            $table->text('transactionUserId');
            $table->text('transactionSlipNo');
            $table->text('transactionNote')->nullable();
            $table->text('transactionTableId');
            $table->text('transactionServedBy');
            $table->text('transactionStatus');
            $table->text('transactionKitchenStatus');
            $table->text('transactionBarStatus');
            $table->text('transactionOutsourcedStatus');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
