<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDataTypeOnSmsConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_configs', function (Blueprint $table) {
            $table->text('masking_name')->change();
            $table->text('user_name')->change();
            $table->text('user_password')->change();
            $table->text('sms_quantity')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sms_configs', function (Blueprint $table) {
            $table->string('masking_name')->change();
            $table->string('user_name')->change();
            $table->string('user_password')->change();
            $table->integer('sms_quantity')->change();
        });
    }
}
