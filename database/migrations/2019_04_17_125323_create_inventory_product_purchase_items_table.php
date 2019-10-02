<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryProductPurchaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_product_purchase_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('inventory_product_purchase_id');
            $table->unsignedInteger('product_id');
            $table->integer('pack_size');
            $table->integer('quantity');
            $table->integer('retail_quantity');
            $table->double('unit_tp');
            $table->double('sales_price');
            $table->double('retail_sales_price');
            $table->double('unit_vat');
            $table->date('expiry_date');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('inventory_products');
            $table->foreign('inventory_product_purchase_id', 'fk_ipp_id')->references('id')->on('inventory_product_purchases')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_product_purchase_items');
    }
}
