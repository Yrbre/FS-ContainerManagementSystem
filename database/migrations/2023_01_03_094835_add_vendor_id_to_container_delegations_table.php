<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVendorIdToContainerDelegationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('container_delegations', function (Blueprint $table) {
            $table->foreignId('vendor_id')->constrained();
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
                $table->dropForeign(['vendor_id']);

                $table->dropColumn('vendor_id');
        });
    }
}
