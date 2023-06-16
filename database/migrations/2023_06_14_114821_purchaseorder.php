<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Purchaseorder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id("purchaseOrderId");
            $table->string('customerCode');
            $table->string('salesman');
            $table->string('customerType');
            $table->string('address');
            $table->string('poNumber');
            $table->string('salesmanCode');
            $table->string('terms');
            $table->string('page');
            $table->string('productCode');
            $table->string('description');
            $table->string('quantity');
            $table->string('unitPrice');
            $table->string('productDiscount');
            $table->string('amount');
            $table->string('taxCode');
            $table->string('lotNumber');
            $table->string('expiryDate');
            $table->string('split');
            $table->string('order');
            $table->string('delivered');
            $table->string('uom');
            $table->string('unitPriceWOVat');
            $table->string('unitPriceWithVat');
            $table->string('rate');
            $table->string('productDiscountWOVat');
            $table->string('productDiscountWithVat');
            $table->string('amountWithVat');
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
