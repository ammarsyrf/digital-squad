<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    protected $table = 'lamaran';
    protected $primaryKey = 'id_lamaran';

    protected $fillable = [
        'talent_id',
        'lowongan_id',
        'status',
        'cv_path',
        'cover_letter'
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class, 'talent_id', 'id_talent');
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id', 'id_lowongan');
    }
}
