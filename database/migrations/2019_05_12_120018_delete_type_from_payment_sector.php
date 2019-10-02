<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteTypeFromPaymentSector extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_sector', function (Blueprint $table) {
            $table->dropColumn('sector_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_sector', function (Blueprint $table) {
            $table->tinyInteger('sector_type')->comment('1 = general, 2 = asset, 3 = loan');
        });
    }
}
