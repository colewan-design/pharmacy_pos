<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Devices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id("deviceId");
            $table->text('departmentId')->comment('department where this device is used!');
            $table->text('deviceName');
            $table->text('deviceDescription');
            $table->char('deviceUse')->default('Y')->comment('Y/N');
            $table->char('deviceIsDeleted')->default('N')->comment('Y/N');
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
