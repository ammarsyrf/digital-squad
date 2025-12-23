<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilTes extends Model
{
    protected $table = 'hasil_tes';
    protected $fillable = [
        'user_id',
        'kategori_id',
        'skor',
        'total_soal',
        'jawaban_benar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriSkill::class, 'kategori_id');
    }
}
