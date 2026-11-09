<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainerDailyActivityDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_daily_activity_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ct_daily_activity_id')->constrained('container_daily_activities', 'id')->onDelete('cascade');
            $table->string('container_code', 7);
            $table->foreign('container_code')->references('code')->on('containers');
            $table->integer('carriage_number');
            $table->string('container_source');
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
        Schema::dropIfExists('container_daily_activity_details');
    }
}
