<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainerDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_documents', function (Blueprint $table) {
            $table->id();
            $table->string('container_code', 7);
            $table->foreign('container_code')->references('code')->on('containers');
            $table->string('file_name');
            $table->string('document_location');
            $table->string('mimeType');
            $table->string('extension');
            $table->double('size');
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
        Schema::dropIfExists('container_documents');
    }
}
