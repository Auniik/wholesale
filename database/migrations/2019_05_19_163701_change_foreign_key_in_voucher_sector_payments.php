<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeForeignKeyInVoucherSectorPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('voucher_sector_payments', function (Blueprint $table) {
            $table->dropForeign(['sector_id']);
            $table->foreign('sector_id')->references('id')->on('voucher_sectors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('voucher_sector_payments', function (Blueprint $table) {
            $table->dropForeign(['sector_id']);
            $table->foreign('sector_id')->references('id')->on('payment_sector');
        });
    }
}
