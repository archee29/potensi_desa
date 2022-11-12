<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $table = 'tb_sekolah';
    protected $guarded = [];

    public function lokasi(){
        return $this->belongsTo(Lokasi::class, 'id');
    }

    public function jenispotensi(){
        return $this->hasMany(JenisPotensi::class, 'id');
    }
    use HasFactory;
}
