<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSaleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sale_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_sale_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('product_code_id');
            $table->integer('quantity');
            $table->double('sales_price', 10, 2);
            $table->double('item_price', 10, 2);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('product_code_id')->references('id')->on('product_codes');
            $table->foreign('product_sale_id')->references('id')->on('product_sales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_sale_items');
    }
}
