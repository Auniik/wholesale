<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\Type;

class ChangeUnitVatInventoryProductPurchaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up()
    {
        if (!Type::hasType('double')) {
            Type::addType('double', FloatType::class);
        }
        Schema::table('inventory_product_purchase_items', function (Blueprint $table) {
            $table->double('unit_vat')->nullable(true)->change();
            $table->date('expiry_date')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down()
    {
        if (!Type::hasType('double')) {
            Type::addType('double', FloatType::class);
        }
        Schema::table('inventory_product_purchase_items', function (Blueprint $table) {
            $table->double('unit_vat')->nullable(false)->change();
            $table->date('expiry_date')->nullable(false)->change();
        });
    }
}
