<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->index();
            $table->foreignId('vendor_id')->constrained()->onDelete('cascade');
            $table->string('subject');
            $table->string('type'); // Pengadaan / Maintenance / Upgrade & Repair
            $table->dateTime('active_date_start');
            $table->dateTime('active_date_end');
            $table->dateTime('warranty_date_start')->nullable();
            $table->dateTime('warranty_date_end')->nullable();
            $table->integer('warranty_in_days')->nullable();
            $table->integer('warranty_in_month')->nullable();
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
        Schema::dropIfExists('contracts');
    }
}
