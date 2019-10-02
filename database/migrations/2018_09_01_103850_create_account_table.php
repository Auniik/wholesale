<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->increments('id');
            $table->float('opening_balance');
            $table->text('description')->nullable();
            $table->tinyInteger('status');
            $table->string('account_name')->nullable()->comment('Bank Name');
            $table->string('branch_name')->nullable();
            $table->string('SWIFT')->nullable();
            $table->string('routing_number')->nullable();
            $table->unsignedInteger('created_by')->index();
            $table->unsignedInteger('fk_company_id')->index();
            $table->unsignedInteger('updated_by')->index();
            $table->float('current_balance');

            $table->tinyInteger('default_status')->default(0);

            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('fk_company_id')->references('id')->on('company_list')->onDelete('cascade');
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
        Schema::dropIfExists('account');
    }
}
