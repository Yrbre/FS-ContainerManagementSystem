<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainerDailyActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_daily_activities', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('location_id');
            $table->string('type');
            $table->dateTime('action_date');

            // Std Column
            $table->string('status')->default('DRAFT')->index();
            $table->foreignId('created_by')->nullable()->constrained('admins');
            $table->foreignId('last_updated_by')->nullable()->constrained('admins');
            $table->dateTime('post_date')->nullable();
            $table->foreignId('post_by')->nullable()->constrained('admins');
            // End Std Column
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('container_daily_activities');
    }
}
