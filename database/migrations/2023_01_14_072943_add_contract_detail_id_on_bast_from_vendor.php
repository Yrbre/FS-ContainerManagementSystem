<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContractDetailIdOnBastFromVendor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('container_delegation_from_vendor_sub_details', function (Blueprint $table) {
                       $table->foreignId('contract_detail_id')->nullable();

            $table->foreign('contract_detail_id', 'fk_vendor_sub_contract_detail')
                ->references('id')
                ->on('contract_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('container_delegation_from_vendor_sub_details', function (Blueprint $table) {
                     $table->dropForeign('fk_vendor_sub_contract_detail');

            $table->dropColumn('contract_detail_id');
        });
    }
}
