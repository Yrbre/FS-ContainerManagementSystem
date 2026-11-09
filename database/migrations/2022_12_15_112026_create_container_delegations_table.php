<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainerDelegationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_delegations', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('location_id');
            $table->string('type'); // To Vendor / From Vendor
            $table->dateTime('action_date');
            $table->foreignId('contract_id')->constrained()->onDelete('cascade');
            
            // Std Column
            $table->string('status')->default('DRAFT')->index();
            $table->foreignId('created_by')->nullable()->constrained('admins');
            $table->foreignId('last_updated_by')->nullable()->constrained('admins');
            $table->dateTime('post_date')->nullable();
            $table->foreignId('post_by')->nullable()->constrained('admins');
            $table->dateTime('approve_date')->nullable();
            $table->foreignId('approve_by')->nullable()->constrained('admins');
            $table->dateTime('approve2_date')->nullable();
            $table->foreignId('approve2_by')->nullable()->constrained('admins');
            $table->dateTime('approve3_date')->nullable();
            $table->foreignId('approve3_by')->nullable()->constrained('admins');
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
        Schema::dropIfExists('container_delegations');
    }
}
