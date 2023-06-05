<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id("tableId");
            $table->text('tableNumber');
            $table->text('tableName');
            $table->text('tableDescription');
            $table->text('tableCapacity');
            $table->integer('tableOrder');
            $table->char('tableUse')->default('Y')->comment('Y/N');
            $table->char('tableIsDeleted')->default('N')->comment('Y/N');
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
