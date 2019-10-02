<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('voucher_installments');

        Schema::create('installments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id')->index();
            $table->string('purpose');
            $table->date('date');
            $table->double('amount', 10, 2);
            $table->morphs('installmentable');
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->timestamp('paid_date')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('installments');
    }
}
