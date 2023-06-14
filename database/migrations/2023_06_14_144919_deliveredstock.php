<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Deliveredstock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivered_stocks', function (Blueprint $table) {
            $table->id("deliveredStockId");
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
