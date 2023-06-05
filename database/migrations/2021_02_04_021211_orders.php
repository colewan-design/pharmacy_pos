<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id("orderId");
            $table->text('transactionId');
            $table->text('itemId');
            $table->text('categoryId');
            $table->integer('orderQty');
            $table->double('orderPrice');
            $table->double('orderTotal');
            $table->integer('orderStatus')->default('0')->comment('1 if printed/ 0 if not printed');
            $table->integer('orderServed')->default('0')->comment('1 if served/ 0 if not served');
            $table->text('itemNote');
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
