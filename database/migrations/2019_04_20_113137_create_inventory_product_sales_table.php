<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryProductSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_product_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id')->index();
            $table->unsignedInteger('created_by')->index();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('invoice_id');
            $table->string('customer_name')->nullable();
            $table->date('date');
            $table->double('subtotal', 10, 2)->nullable();
            $table->double('discount', 10, 2)->nullable();
            $table->double('previous_due', 10, 2)->nullable();
            $table->double('paid_amount', 10, 2)->nullable();
            $table->double('change_amount', 10, 2)->nullable();
            $table->double('due_amount', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('company_list');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_product_sales');
    }
}
