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
        Schema::create('ds_digipos_sbs', function (Blueprint $table) {
            $table->string('branch');
            $table->string('mitra_sbp');
            $table->string('cluster');
            $table->string('city');
            $table->string('nama_direct_sales');
            $table->string('user_id', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ds_digipos_sbs');
    }
};
