<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('outdoor_discount')->default('0');
            $table->boolean('outdoor_sms')->default('0');
            $table->boolean('indoor_discount')->default('1');
            $table->boolean('service_discount')->default('1');
            $table->unsignedInteger('company_id');
            $table->foreign('company_id')->references('id')->on('company_list')->onDelete('cascade');
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
        Schema::dropIfExists('system_configs');
    }
}
