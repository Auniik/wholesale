<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('quotation_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('product_code_id');
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->double('unit_tp', 10, 2);
            $table->double('amount', 10, 2);
            $table->double('discount', 10, 2);
            $table->timestamps();

            $table->foreign('quotation_id')->references('id')->on('quotations');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('product_code_id')->references('id')->on('product_codes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotation_items');
    }
}
