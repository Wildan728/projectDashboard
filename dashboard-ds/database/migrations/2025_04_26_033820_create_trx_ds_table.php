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
        Schema::create('trx_ds', function (Blueprint $table) {
            $table->string('id');
            $table->string('trx_type');
            $table->string('transaction_id');
            $table->integer('event_id');
            $table->string('status');
            $table->string('status_desc');
            $table->string('product_id');
            $table->string('product_name');
            $table->string('sub_product_name');
            $table->integer('price');
            $table->integer('admin_fee');
            $table->integer('star_point');
            $table->integer('msisdn');
            $table->string('product_category');
            $table->dateTime('created_at');
            $table->BigInteger('created_by');
            $table->dateTime('updated_at');
            $table->BigInteger('updated_by');
            $table->string('a_event_name');
            $table->string('payment_method');
            $table->string('serial_number');
            $table->BigInteger('user_id');
            $table->string('code');
            $table->string('name');
            $table->integer('sales_territory_level');
            $table->integer('sales_territory_value');
            $table->string('wok');
            $table->string('branch_id');
            $table->string('cluster_name');
            $table->string('branch');
            $table->string('regional');
            $table->string('area_name');
            $table->string('custbase_brand');
            $table->date('payload_first_payload_date');
            $table->string('event_name');
            $table->string('poi_id');
            $table->string('poi_name');
            $table->string('category_name');
            $table->integer('npsn');
            $table->string('longitude');
            $table->string('latitude');
            $table->string('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trx_ds');
    }
};