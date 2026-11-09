<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDamageRootCauseToContainerDelegationFromVendorSubDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('container_delegation_from_vendor_sub_details', function (Blueprint $table) {
            $table->string('damage_description')->nullable();
            $table->string('root_cause')->nullable();
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
            $table->dropColumn(['damage_description', 'root_cause']);
        });
    }
}
