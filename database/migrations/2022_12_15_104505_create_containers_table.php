<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('containers', function (Blueprint $table) {
            $table->string('code', 7)->primary();
            $table->foreignId('vendor_id')->constrained();
            $table->foreignId('container_status_id')->constrained();
            $table->string('fixed_asset_number');
            $table->dateTime('buy_date');
            $table->foreignId('last_upgrade_vendor_id')->nullable()->constrained('vendors', 'id');
            $table->foreignId('last_maintenance_vendor_id')->nullable()->constrained('vendors', 'id');
            $table->foreignId('contract_id')->nullable()->constrained();
            $table->float('length')->nullable();
            $table->float('height')->nullable();
            $table->float('width')->nullable();
            $table->dateTime('last_upgrade_date')->nullable();
            $table->dateTime('last_maintenance_date')->nullable();
            $table->dateTime('warranty_date_start')->nullable();
            $table->dateTime('warranty_date_end')->nullable();
            $table->foreignId('company_id')->constrained();
            $table->string('down_carriage_no')->nullable();
            $table->string('up_carriage_no')->nullable();
            $table->foreignId('down_location_id')->nullable()->constrained('locations', 'id');
            $table->foreignId('up_location_id')->nullable()->constrained('locations', 'id');
            $table->text('description');
            $table->foreignId('created_by')->constrained('admins');
            $table->softDeletes();
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
        Schema::dropIfExists('containers');
    }
}
