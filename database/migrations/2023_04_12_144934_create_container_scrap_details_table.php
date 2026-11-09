<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainerScrapDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_scrap_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('container_scrap_id')->constrained()->onDelete('cascade');
            $table->string('container_code', 7);
            $table->foreign('container_code')->references('code')->on('containers');
            $table->decimal('persentase', 5, 2)->default(0);
            $table->string('description')->nullable();
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
        Schema::dropIfExists('container_scrap_details');
    }
}
