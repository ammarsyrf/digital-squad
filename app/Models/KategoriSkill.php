<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriSkill extends Model
{
    protected $table = 'kategori_skill';
    protected $primaryKey = 'id_kategori_skill';
    public $timestamps = false;

    protected $fillable = ['nama_kategori'];

    public function soal()
    {
        return $this->hasMany(SoalSkill::class, 'kategori_id', 'id_kategori_skill');
    }
}
