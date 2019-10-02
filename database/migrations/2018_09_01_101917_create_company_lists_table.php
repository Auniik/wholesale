<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name');
            $table->text('logo')->nullable();
            $table->text('address')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('mobile_no');
            $table->string('email')->index();
            $table->string('fax');
            $table->text('favicon')->nullable();
            $table->text('web');
            $table->tinyInteger('status');

            $table->string('bank_name');
            $table->string('account_no');
            $table->string('branch_name');
            $table->string('swift');
            $table->string('routing_no');

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
        Schema::dropIfExists('company_list');
    }
}
