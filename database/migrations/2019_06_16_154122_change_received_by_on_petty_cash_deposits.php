<?php

use App\Models\PettyCashDeposit;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Doctrine\DBAL\Types\Type;
use phpDocumentor\Reflection\Types\Integer;

class ChangeReceivedByOnPettyCashDeposits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('petty_cash_deposits', function (Blueprint $table) {
            $table->unsignedInteger('received_by')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('petty_cash_deposits', function (Blueprint $table) {
            $table->string('received_by')->change();
        });
    }
}
