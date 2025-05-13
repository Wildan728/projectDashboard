<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxDs extends Model
{
    use HasFactory;

    protected $table = 'trx_ds';

    protected $primaryKey = 'id'; // Atau nama kolom yang kamu gunakan
    public $incrementing = false; // Jika kamu menggunakan string (bukan auto increment)
    protected $keyType = 'string'; // Pastikan ini 'string' jika id adalah string

    protected $fillable = [
        'id',
        'trx_type',
        'transaction_id',
        'event_id',
        'status',
        'status_desc',
        'product_id',
        'product_name',
        'sub_product_name',
        'price',
        'admin_fee',
        'star_point',
        'msisdn',
        'product_category',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'a_event_name',
        'payment_method',
        'serial_number',
        'user_id',
        'code',
        'name',
        'sales_territory_level',
        'sales_territory_value',
        'wok',
        'branch_id',
        'cluster_name',
        'branch',
        'regional',
        'area_name',
        'custbase_brand',
        'payload_first_payload_date',
        'event_name',
        'poi_id',
        'poi_name',
        'category_name',
        'npsn',
        'longitude',
        'latitude',
        'address'
    ];
}