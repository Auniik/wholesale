<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePartyIdInventoryProductPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_product_purchases', function (Blueprint $table) {

//            $table->dropForeign(['party_id']);
            $table->dropColumn('party_id');
        });
        Schema::table('inventory_product_purchases', function (Blueprint $table) {
            $table->unsignedInteger('manufacturer_id')->index();
            $table->foreign('manufacturer_id')->references('id')->on('inventory_brands');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_product_purchases', function (Blueprint $table) {
            $table->unsignedInteger('party_id')->index();
//            $table->foreign('party_id')->references('id')->on('parties');

            $table->dropForeign(['manufacturer_id']);
            $table->dropColumn('manufacturer_id');
        });
    }
}
