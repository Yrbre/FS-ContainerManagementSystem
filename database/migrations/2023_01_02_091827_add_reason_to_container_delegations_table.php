<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReasonToContainerDelegationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('container_delegations', function (Blueprint $table) {
            $table->text('reason_approve')->nullable()->after('approve3_by');
            $table->text('reason_reject')->nullable()->after('reason_approve');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('container_delegations', function (Blueprint $table) {
            $table->dropColumn(['reason_approve', 'reason_reject']);
        });
    }
}
