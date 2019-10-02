<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalanceTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('transfer_from')->index();
            $table->unsignedInteger('transfer_to')->index();
            $table->timestamp('date');
            $table->double('amount', 10,2);
            $table->text('description')->nullable();
            $table->unsignedInteger('company_id')->index();
            $table->unsignedInteger('created_by')->index();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('transfer_from')->references('id')->on('account');
            $table->foreign('transfer_to')->references('id')->on('account');
            $table->foreign('company_id')->references('id')->on('company_list');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balance_transfers');
    }
}
