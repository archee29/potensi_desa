<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
protected $table = 'tb_desa';

    public function sekolah(){
        return $this->hasMany(Sekolah::class, 'id');
    }

    public function tempatibadah(){
        return $this->belongsTo(RumahIbadah::class, 'id');
    }
    public function pasar(){
        return $this->belongsTo(Pasar::class, 'id');
    }

    public function tempatwisata(){
        return $this->belongsTo(TempatWisata::class, 'id');
    }

    // public function kecamatan(){
    //     return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    // }

    use HasFactory;
}
