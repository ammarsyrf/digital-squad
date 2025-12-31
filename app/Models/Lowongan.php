<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    protected $table = 'lowongan';

    protected $fillable = [
        'umkm_id',
        'judul',
        'deskripsi',
        'tipe_pekerjaan',
        'lokasi',
        'gaji',
        'status',
        'sistem_kerja',
        'fasilitas'
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    public function lamaran()
    {
        return $this->hasMany(Lamaran::class);
    }
}
