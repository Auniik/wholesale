<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('stock_limitation')->nullable();
            $table->unsignedInteger('category_id')->index();
            $table->unsignedInteger('unit_id');
            $table->unsignedInteger('wholesale_unit_id')->nullable();
            $table->unsignedInteger('brand_id');
            $table->integer('retail_quantity')->default(0);
            $table->double('retail_unit_tp')->default(0);
            $table->double('retail_sales_price')->default(0);
            $table->unsignedInteger('company_id')->index();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('company_list');
            $table->foreign('unit_id')->references('id')->on('inventory_units');
            $table->foreign('brand_id')->references('id')->on('inventory_brands');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('wholesale_unit_id')->references('id')->on('inventory_units');
            $table->foreign('category_id')->references('id')->on('inventory_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_products');
    }
}
