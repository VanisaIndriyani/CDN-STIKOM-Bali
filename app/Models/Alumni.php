<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $table = 'alumni';  // Add this line to specify the table name

    protected $fillable = [
        'nama',
        'nim',
        'tahun_lulus',
        'periode_wisuda',
        'tahun_yudisium',
        'pekerjaan',
        'perusahaan',
        'bidang',
        'rata_rata_gaji',
        'relevansi'
    ];

    protected $casts = [
        'tahun_lulus' => 'integer',
        'tahun_yudisium' => 'integer',
        'relevansi' => 'boolean'
    ];
}