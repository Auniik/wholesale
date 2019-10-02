<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoucherPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('voucher_id');
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('method_id');
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('account');
            $table->foreign('method_id')->references('id')->on('account_payment_method');
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('cascade');
        });

        Schema::table('voucher_sector_payments', function (Blueprint $table){
            $table->unsignedInteger('voucher_payment_id');

            $table->foreign('voucher_payment_id')->references('id')->on('voucher_payments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('voucher_sector_payments', function (Blueprint $table){
            $table->dropForeign(['voucher_payment_id']);

            $table->dropColumn('voucher_payment_id');
        });

        Schema::dropIfExists('voucher_payments');
    }
}
