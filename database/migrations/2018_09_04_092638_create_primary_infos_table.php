<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrimaryInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('primary_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name');
            $table->string('logo');
            $table->text('address');
            $table->string('mobile_no');
            $table->string('email');
            $table->string('fb_link')->nullable();
            $table->string('favicon')->nullable();
            $table->longText('description');
            $table->string('web')->nullable();
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
        Schema::dropIfExists('primary_info');
    }
}
