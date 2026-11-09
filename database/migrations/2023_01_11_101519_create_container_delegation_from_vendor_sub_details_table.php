<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainerDelegationFromVendorSubDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_delegation_from_vendor_sub_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ct_from_vendor_detail_id');
            $table->foreign('ct_from_vendor_detail_id', 'fk_vendor_sub_detail')
                ->references('id')
                ->on('container_delegation_from_vendor_details')
                ->onDelete('cascade');
            $table->string('job_type');
            $table->string('material_size');
            $table->text('description');
            $table->integer('qty');
            $table->string('unit');
            $table->double('unit_price');
            $table->float('price_estimation');
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
        Schema::dropIfExists('container_delegation_from_vendor_sub_details');
    }
}
