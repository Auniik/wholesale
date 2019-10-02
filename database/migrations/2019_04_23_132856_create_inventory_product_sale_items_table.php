<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryProductSaleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_product_sale_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('inventory_product_sale_id');
            $table->unsignedInteger('product_id');
            $table->integer('sales_qty');
            $table->double('sales_price', 10, 2);
            $table->double('item_price', 10, 2);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('inventory_products');
            $table->foreign('inventory_product_sale_id', 'fk_ips_id')->references('id')->on('inventory_product_sales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_product_sale_items');
    }
}
