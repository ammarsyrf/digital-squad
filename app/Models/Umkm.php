<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    protected $table = 'umkm';
    protected $primaryKey = 'id_umkm';

    protected $fillable = [
        'user_id',
        'nama_perusahaan',
        'nama_umkm',
        'deskripsi',
        'alamat',
        'telepon',
        'email_instansi',
        'website',
        'logo',
        'dokumen_verifikasi',
        'status_verifikasi',
        'catatan_admin'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lowongan()
    {
        return $this->hasMany(Lowongan::class);
    }
}
