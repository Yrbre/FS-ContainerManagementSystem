<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainerDelegationFromVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_delegation_from_vendors', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('location_id');
            $table->string('job_type');
            $table->dateTime('action_date');
            $table->foreignId('vendor_id')->constrained()->onDelete('cascade');

            // Std Column
            $table->string('status')->default('DRAFT');
            $table->foreignId('created_by')->nullable()->constrained('admins');
            $table->foreignId('last_updated_by')->nullable()->constrained('admins');
            $table->dateTime('post_date')->nullable();
            $table->foreignId('post_by')->nullable()->constrained('admins');
            $table->dateTime('approve_date')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('admins');
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
        Schema::dropIfExists('container_delegation_from_vendors');
    }
}
