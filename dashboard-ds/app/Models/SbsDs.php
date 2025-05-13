<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SbsDs extends Model
{
    use HasFactory;
    protected $table = 'ds_digipos_sbs';

    // Karena primary key-nya bukan 'id', kita harus set primaryKey
    protected $primaryKey = 'user_id';

    // Karena primary key bukan auto-increment integer, kita harus matikan incrementing
    public $incrementing = false;

    // Tipe data primary key (karena kamu pakai bigInteger)
    protected $keyType = 'int';

    // Kalau kamu gak pakai timestamps (created_at, updated_at), disable
    public $timestamps = false;

    // Mass assignment fields
    protected $fillable = [
        'branch',
        'mitra_sbp',
        'cluster',
        'city',
        'nama_direct_sales',
        'user_id',
    ];
}
