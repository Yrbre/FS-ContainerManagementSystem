<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReasonToContainerScrapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('container_scraps', function (Blueprint $table) {
            $table->text('reason_approve')->nullable();
            $table->text('reason_reject')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('container_scraps', function (Blueprint $table) {
            $table->dropColumn(['reason_approve', 'reason_reject']);
        });
    }
}
