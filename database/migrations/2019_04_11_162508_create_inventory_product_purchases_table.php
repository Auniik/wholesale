<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryProductPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_product_purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id')->index();
            $table->unsignedInteger('created_by')->index();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('party_id')->index();
            $table->string('challan_id');
            $table->date('date');
            $table->double('subtotal', 12, 2);
            $table->double('total_vat', 12, 2);
            $table->double('discount', 12, 2);
            $table->double('paid_amount', 12, 2);
            $table->unsignedInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

//            $table->foreign('party_id')->references('id')->on('parties');
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
        Schema::dropIfExists('inventory_product_purchases');
    }
}
