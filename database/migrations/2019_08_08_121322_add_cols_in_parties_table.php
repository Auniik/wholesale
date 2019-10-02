<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColsInPartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parties', function (Blueprint $table) {
            $table->text('address')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_designation')->nullable();
            $table->string('contact_person_department')->nullable();
            $table->string('contact_person_telephone')->nullable();
            $table->string('contact_person_mobile')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parties', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('contact_person_name');
            $table->dropColumn('contact_person_designation');
            $table->dropColumn('contact_person_department');
            $table->dropColumn('contact_person_telephone');
            $table->dropColumn('contact_person_mobile');
        });
    }
}
