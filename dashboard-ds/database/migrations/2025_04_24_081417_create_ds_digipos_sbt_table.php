<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ds_digipos_sbt', function (Blueprint $table) {
            $table->string('id_digipos');
            $table->string('no_rs');
            $table->string('nama_ds');
            $table->string('tap');
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->string('cluster');
            $table->string('regional');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ds_digipos_sbt');
    }
};