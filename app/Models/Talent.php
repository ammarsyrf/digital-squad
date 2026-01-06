<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talent extends Model
{
    protected $table = 'talent';
    protected $primaryKey = 'id_talent';
    public $timestamps = false; // Karena tabel native tidak punya updated_at secara default

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'deskripsi',
        'tanggal_lahir',
        'umur',
        'jenis_kelamin',
        'status_pernikahan',
        'alamat',
        'telepon',
        'hobi',
        'pekerjaan_saat_ini',
        'pengalaman_kerja',
        'pendidikan_terakhir',
        'skill',
        'linkedin',
        'portfolio',
        'foto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lamaran()
    {
        return $this->hasMany(Lamaran::class, 'talent_id');
    }
}
