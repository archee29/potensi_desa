<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempatWisata extends Model
{
    protected $table = 'tb_tempat_wisata';
    protected $guarded=[];

    public function lokasi(){
        return $this->belongsTo(Lokasi::class, 'id_desa');
    }

    public function jenispotensi(){
        return $this->hasMany(JenisPotensi::class, 'id_potensi');
    }
    public function getImage(){
        if(substr($this->image,o,5)=="https"){
            return $this->image;
        }
        if($this->image){
            return asset('/images/Poto-Kalimas/pasar/'.$this->image);
        }
        return 'https://via.placeholder.com/500x500.png?text=No+Cover';
    }
    use HasFactory;
}
