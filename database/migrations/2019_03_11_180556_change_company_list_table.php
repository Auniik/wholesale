<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCompanyListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_list', function (Blueprint $table) {
//            $table->dropIfExists('bank_name');
//            $table->dropIfExists('account_no');
//            $table->dropIfExists('branch_name');
//            $table->dropIfExists('swift');
//            $table->dropIfExists('routing_no');
//            $table->dropIfExists('favicon')->nullable();
//            $table->dropIfExists('shipping_address')->nullable();

            $table->string('mobile_no')->nullable()->change();
            $table->string('fax')->nullable()->change();
            $table->text('web')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_list', function (Blueprint $table) {
//            $table->string('bank_name');
//            $table->string('account_no');
//            $table->string('branch_name');
//            $table->string('swift');
//            $table->string('routing_no');
//            $table->text('favicon')->nullable();
//            $table->text('shipping_address')->nullable();

            $table->text('web')->change();
            $table->string('mobile_no')->change();
            $table->string('fax')->change();
        });
    }
}
