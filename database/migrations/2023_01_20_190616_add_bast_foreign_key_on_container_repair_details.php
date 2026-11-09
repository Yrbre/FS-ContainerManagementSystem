<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBastForeignKeyOnContainerRepairDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('container_repair_details', function (Blueprint $table) {
            $table->foreignId('container_delegation_detail_id')->nullable()->constrained('container_delegation_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('container_repair_details', function (Blueprint $table) {
            $table->dropColumn(['container_delegation_detail_id']);
        });
    }
}
