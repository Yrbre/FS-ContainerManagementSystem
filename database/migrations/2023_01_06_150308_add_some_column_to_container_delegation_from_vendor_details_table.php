<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnToContainerDelegationFromVendorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('container_delegation_from_vendor_details', function (Blueprint $table) {
            $table->dateTime('delegation_to_vendor_date');
            $table->decimal('progress', 5, 2)->default(0);
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
            $table->dropColumn(['delegation_to_vendor_date', 'progress']);
        });
    }
}
