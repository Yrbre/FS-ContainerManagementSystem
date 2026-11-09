<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToContainerDailyActivityDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('container_daily_activity_details', function (Blueprint $table) {
            $table->string('type')->nullable()->after('container_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('container_daily_activity_details', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
