<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuotationItemIdInChallanItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('challan_items', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
            $table->unsignedInteger('quotation_item_id');
            $table->foreign('quotation_item_id')->references('id')->on('quotation_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('challan_items', function (Blueprint $table) {
            $table->dropForeign(['quotation_item_id']);
            $table->dropColumn('quotation_item_id');

            $table->unsignedInteger('product_id');

            $table->foreign('product_id')->references('id')->on('products');

        });
    }
}
