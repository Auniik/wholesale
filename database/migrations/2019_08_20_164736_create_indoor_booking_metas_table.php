<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndoorBookingMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indoor_booking_metas', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('booking_id');
            $table->enum('status', ['admitted', 'migrated', 'released']);
            $table->unsignedInteger('migrated_form')->nullable();
            $table->unsignedInteger('migrated_to')->nullable();
            $table->timestamps();


            $table->foreign('booking_id')
                ->references('id')->on('indoor_patient_bookings')->onDelete('cascade');
            $table->foreign('migrated_to')
                ->references('id')->on('indoor_patient_bookings')->onDelete('cascade');
            $table->foreign('migrated_form')
                ->references('id')->on('indoor_patient_bookings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indoor_booking_metas');
    }
}
