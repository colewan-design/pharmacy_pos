<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Badorder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bad_orders', function (Blueprint $table) {
            $table->id("badOrderId");
            $table->text("purchaseOrderId");
            $table->string('supplierName');
            $table->text('itemName');
            $table->text('itemDescription');
            $table->text('itemQty');
            $table->text('fromLocation');
            $table->softDeletes();
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
