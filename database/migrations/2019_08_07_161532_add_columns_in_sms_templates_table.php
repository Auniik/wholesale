<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInSmsTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_templates', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('body');
            $table->dropColumn('status');
            $table->text('outdoor')->nullable();
            $table->text('daily_expense_report')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sms_templates', function (Blueprint $table) {
            $table->string('name');
            $table->text('body');
            $table->tinyInteger('body');
            $table->dropColumn('outdoor');
            $table->dropColumn('daily_expense_report');
        });
    }
}
