<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPotensi extends Model
{
    protected $table = 'tb_jenis_potensi';
    protected $guarded = [];

    public function sekolah(){
        return $this->belongsTo(Sekolah::class, 'id');
    }
    public function pasar(){
        return $this->belongsTo(Pasar::class, 'id');
    }

    public function rumah_ibadah(){
        return $this->belongsTo(RumahIbadah::class, 'id');
    }

    public function wisata_desa(){
        return $this->belongsTo(WisataDesa::class, 'id');
    }

    use HasFactory;
}
