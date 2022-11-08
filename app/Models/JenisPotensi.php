<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPotensi extends Model
{
    protected $table = 'tb_jenis_potensi';

    public function sekolah(){
        return $this->belongsTo(Sekolah::class, 'id');
    }
    public function pasar(){
        return $this->belongsTo(Pasar::class, 'id');
    }

    public function tempatibadah(){
        return $this->belongsTo(TempatIbadah::class, 'id');
    }

    public function tempatwisata(){
        return $this->belongsTo(TempatWisata::class, 'id');
    }

    use HasFactory;
}
