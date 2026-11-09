<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWarrantyOnContainerDelegationFromVendorSubDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('container_delegation_from_vendor_sub_details', function (Blueprint $table) {
            $table->dateTime('warranty_start_date')->nullable();
            $table->dateTime('warranty_end_date')->nullable();
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
            $table->dropColumn(['warranty_start_date', 'warranty_end_date']);
        });
    }
}
