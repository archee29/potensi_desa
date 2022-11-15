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
