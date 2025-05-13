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
        Schema::create('resume', function (Blueprint $table) {
            $table->id();
            $table->string('territory');
            $table->integer('all'); // Total DS
            $table->integer('trx'); // Yang transaksi
            $table->decimal('ach_trx', 5, 2); // Persentase trx, misal 56.50
            $table->integer('no_trx'); // Tidak trx
            $table->integer('ranking_ds_trx');
            // Kolom revenue
            $table->bigInteger('data')->default(0);
            $table->bigInteger('digital')->default(0);
            $table->bigInteger('extension')->default(0);
            $table->bigInteger('ppob')->default(0);
            $table->bigInteger('recharge')->default(0);
            $table->bigInteger('roaming')->default(0);
            $table->bigInteger('sellout')->default(0);
            $table->bigInteger('voice_sms')->default(0);
            $table->bigInteger('total')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume');
    }
};