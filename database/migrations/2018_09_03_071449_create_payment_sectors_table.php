<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_sector', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sector_name');
            $table->tinyInteger('sector_type')->comment('1 = general, 2 = asset, 3 = loan');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('type')->comment('1=Expense, 2=Receive');
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
        Schema::dropIfExists('payment_sector');
    }
}
