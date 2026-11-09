<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCarriageNumberToContainerDelegationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('container_delegation_details', function (Blueprint $table) {
            $table->string('carriage_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('container_delegation_details', function (Blueprint $table) {
            $table->dropColumn('carriage_number');
        });
    }
}
