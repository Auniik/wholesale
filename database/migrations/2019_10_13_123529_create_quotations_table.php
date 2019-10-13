<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('invoice_id');
            $table->unsignedInteger('party_id');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('bank_id')->nullable();
            $table->date('validity');
            $table->text('shipping_address');
            $table->double('amount', 10,2);
            $table->double('discount', 10,2);
            $table->timestamps();

            $table->foreign('party_id')->references('id')->on('parties');
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
        Schema::dropIfExists('quotations');
    }
}
