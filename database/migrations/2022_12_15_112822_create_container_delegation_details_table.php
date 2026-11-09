<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainerDelegationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_delegation_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('container_delegation_id')->constrained();
            $table->string('container_code', 7);
            $table->foreign('container_code')->references('code')->on('containers');
            $table->string('container_damage');
            $table->foreignId('contract_detail_id')->constrained();
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
        Schema::dropIfExists('container_delegation_details');
    }
}
