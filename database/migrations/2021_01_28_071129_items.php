<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Items extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id("itemId");
            $table->integer("categoryId")->comment('Categorty ID');
            $table->string("itemName");
            $table->text("itemDescription");
            $table->integer("itemQty");
            $table->double("itemPrice");
            $table->char("itemUse")->default('Y')->comment('Y/N');
            $table->char('itemIsDeleted')->default('N')->comment('Y/N');
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
