<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePettyCashVoucherItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petty_cash_voucher_items', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');
            $table->double('amount', 10, 2);
            $table->unsignedInteger('petty_cash_voucher_id')->index();
            $table->timestamps();

            $table->foreign('petty_cash_voucher_id')->references('id')->on('petty_cash_vouchers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('petty_cash_voucher_items');
    }
}
