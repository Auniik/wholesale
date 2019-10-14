<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPurchaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_purchase_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_purchase_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('product_code_id');
            $table->integer('quantity');
            $table->double('unit_price');
            $table->double('sales_price')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('product_code_id')->references('id')->on('product_codes');
            $table->foreign('product_purchase_id')->references('id')->on('product_purchases');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_purchase_items');
    }
}
