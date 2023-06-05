<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Payments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id("paymentId");
            $table->text("transactionId");
            $table->text("customer");
            $table->text("totalAmount");
            $table->text("discount");
            $table->text("tenderedAmount");
            $table->text("change");
            $table->text("accountReceivableAmount")->default('0');
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
