<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChallanItemInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challan_item_inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('challan_item_id');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('challan_item_id')->references('id')->on('challan_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('challan_item_inventories');
    }
}
