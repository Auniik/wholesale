<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountPaymentMethodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_payment_method', function (Blueprint $table) {
            $table->increments('id');
            $table->string('method_name');
            $table->text('description')->nullable();
            $table->tinyInteger('status');
            $table->unsignedInteger('fk_account_id')->index();
            $table->unsignedInteger('created_by')->index();
            $table->unsignedInteger('fk_company_id')->index();
            $table->unsignedInteger('updated_by')->index();
            $table->timestamps();

            $table->foreign('fk_company_id')->references('id')->on('company_list')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_payment_method');
    }
}
