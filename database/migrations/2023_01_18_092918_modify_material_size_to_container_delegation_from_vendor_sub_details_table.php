<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyMaterialSizeToContainerDelegationFromVendorSubDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('container_delegation_from_vendor_sub_details','material_size')) {
            Schema::table('container_delegation_from_vendor_sub_details', function (Blueprint $table) {
                $table->string('material_size')->nullable()->change();
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
        Schema::table('container_delegation_from_vendor_sub_details', function (Blueprint $table) {
            //
        });
    }
}
