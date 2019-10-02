<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChartsInPettyCashVoucherItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('petty_cash_voucher_items', function (Blueprint $table) {
            $table->unsignedInteger('petty_cash_charts_id')->index();

            $table->foreign('petty_cash_charts_id')->references('id')->on('petty_cash_charts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('petty_cash_voucher_items', function (Blueprint $table) {
            $table->dropForeign(['petty_cash_charts_id']);
            $table->dropColumn('petty_cash_charts_id');
        });
    }
}
