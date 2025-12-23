<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    protected $table = 'lamaran';

    protected $fillable = [
        'talent_id',
        'lowongan_id',
        'status'
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class);
    }
}
