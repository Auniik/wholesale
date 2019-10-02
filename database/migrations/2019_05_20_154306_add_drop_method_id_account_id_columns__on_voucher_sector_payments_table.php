<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDropMethodIdAccountIdColumnsOnVoucherSectorPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vouchers', function (Blueprint $table){
            $table->dropForeign(['account_id']);
            $table->dropForeign(['method_id']);

            $table->dropColumn('account_id', 'method_id');
        });

        Schema::table('voucher_sector_payments', function (Blueprint $table) {
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('method_id');

            $table->foreign('account_id')->references('id')->on('account');
            $table->foreign('method_id')->references('id')->on('account_payment_method');
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
            $table->dropForeign(['account_id']);
            $table->dropForeign(['method_id']);

            $table->dropColumn('account_id', 'method_id');
        });

        Schema::table('vouchers', function (Blueprint $table) {
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('method_id');

            $table->foreign('account_id')->references('id')->on('account');
            $table->foreign('method_id')->references('id')->on('account_payment_method');
        });
    }
}
