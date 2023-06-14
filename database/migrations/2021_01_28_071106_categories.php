<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Categories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id("categoryId");
            $table->integer('departmentId')->comment('department id');
            $table->string('categoryName');
            $table->text('categoryDescription');
            $table->text('categoryStyle')->default('success')->comment('Button Color Hex');
            $table->char('categoryUse')->default('Y')->comment('Y/N');
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
