<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoalSkill extends Model
{
    protected $table = 'soal_skill';

    protected $fillable = [
        'kategori_id',
        'pertanyaan',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'jawaban_benar',
        'kesulitan',
        'status'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriSkill::class, 'kategori_id');
    }
}
