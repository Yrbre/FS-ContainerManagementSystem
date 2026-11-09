<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContractDetailIdToContainerDelegationSubDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('container_delegation_sub_details', function (Blueprint $table) {
            $table->foreignId('contract_detail_id')->after('ct_delegation_detail_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('container_delegation_sub_details', function (Blueprint $table) {
            $table->dropColumn('contract_detail_id');
        });
    }
}
