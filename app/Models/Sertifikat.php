<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    protected $table = 'sertifikat';
    protected $primaryKey = 'id_sertifikat';

    protected $fillable = [
        'user_id',
        'nama_sertifikat',
        'penerbit',
        'tanggal_terbit',
        'deskripsi',
        'file_path',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_users');
    }
}
