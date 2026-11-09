<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainerDelegationSubDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_delegation_sub_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ct_delegation_detail_id')->constrained('container_delegation_details', 'id')->onDelete('cascade');
            $table->foreignId('inspection_detail_id');
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
        Schema::dropIfExists('container_delegation_sub_details');
    }
}
