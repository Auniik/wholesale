<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApprovedByInInventoryProductPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_product_purchases', function (Blueprint $table) {
            $table->unsignedInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
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
            $table->dropColumn('approved_by');
            $table->dropColumn('approved_at');
        });
    }
}