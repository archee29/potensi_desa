<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumahIbadah extends Model
{
    protected $table = 'tb_rumah_ibadah';
    protected $guarded = [];

    public function lokasi(){
        return $this->belongsTo(Lokasi::class, 'id_desa');
    }

    // public function jenispotensi(){
    //     return $this->hasMany(JenisPotensi::class, 'id_potensi');
    // }

    public function getImage(){
        if(substr($this->image,0,5)=="https"){
            return $this->image;
        }
        if($this->image){
            return asset('/images/Poto-Kalimas/rumah ibadah/'.$this->image);
        }
        return 'https://via.placeholder.com/500x500.png?text=No+Cover';
    }
    use HasFactory;
}
