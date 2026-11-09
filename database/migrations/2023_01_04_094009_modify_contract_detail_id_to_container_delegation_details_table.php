<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyContractDetailIdToContainerDelegationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('container_delegation_details','contract_detail_id')) {
            Schema::table('container_delegation_details', function (Blueprint $table) {
                $table->dropConstrainedForeignId('contract_detail_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('container_delegation_details', function (Blueprint $table) {
            //
        });
    }
}
