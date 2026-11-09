<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBastToVendorRelationToBastFromVendor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('container_delegation_from_vendor_details', function (Blueprint $table) {
            $table->foreignId('container_delegation_detail_id')->nullable();

            $table->foreign(
                'container_delegation_detail_id',
                'fk_vendor_delegation_detail'
            )
                ->references('id')
                ->on('container_delegation_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('container_delegation_from_vendor_details', function (Blueprint $table) {
             $table->dropForeign('fk_vendor_delegation_detail');

            $table->dropColumn('container_delegation_detail_id');
        });
    }
}
