<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainerDelegationFromVendorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('container_delegation_from_vendor_details');
        Schema::create('container_delegation_from_vendor_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_vendor_id')->constrained('container_delegation_from_vendors', 'id')->onDelete('cascade');
            $table->string('container_code', 7);
            $table->foreign('container_code')->references('code')->on('containers');
            $table->string('container_damage');
            $table->json('images');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('container_delegation_from_vendor_details');
    }
}
