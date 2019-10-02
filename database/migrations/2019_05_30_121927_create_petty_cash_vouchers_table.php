<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePettyCashVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petty_cash_vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->double('amount', 10, 2);
            $table->unsignedInteger('company_id')->index();
            $table->unsignedInteger('created_by')->index();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('company_list');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('petty_cash_vouchers');
    }
}
