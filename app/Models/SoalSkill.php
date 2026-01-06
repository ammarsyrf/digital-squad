<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoalSkill extends Model
{
    protected $table = 'soal_skill';
    protected $primaryKey = 'id_soal_skill';

    protected $fillable = [
        'kategori_id',
        'tipe_soal',
        'pertanyaan',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'jawaban_benar',
        'kunci_jawaban_essay',
        'kesulitan',
        'status'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriSkill::class, 'kategori_id', 'id_kategori_skill');
    }
}
