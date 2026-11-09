<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDelegationToVendorDateToContainerDelegationFromVendorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('container_delegation_from_vendor_details','delegation_to_vendor_date')) {
            Schema::table('container_delegation_from_vendor_details', function (Blueprint $table) {
                $table->dateTime('delegation_to_vendor_date')->nullable()->change();
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
        Schema::table('container_delegation_from_vendor_details', function (Blueprint $table) {
            //
        });
    }
}
