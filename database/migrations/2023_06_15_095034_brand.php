<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Brand extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id("brandId");
            $table->integer('categoryId')->comment('Category Id');
            $table->string('brandName');
            $table->text('brandDescription');
            $table->text('brandStyle')->default('success')->comment('Button Color Hex');
            $table->char('brandUse')->default('Y')->comment('Y/N');
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
