<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $table = 'tb_desa';
    protected $guarded = [];

    public function sekolah(){
        return $this->hasMany(Sekolah::class, 'id');
    }

    public function rumah_ibadah(){
        return $this->belongsTo(RumahIbadah::class, 'id');
    }
    public function pasar(){
        return $this->belongsTo(Pasar::class, 'id');
    }

    public function wisata_desa(){
        return $this->belongsTo(WisataDesa::class, 'id');
    }


    public function getImage(){
        if(substr($this->image,0, 5)=="https"){
            return $this->image;
        }
        if($this->image){
            return asset('/images/Poto-Kalimas/desa/' . $this->image);
        }
        return 'https://via.placeholder.com/500x500.png?text=No+Cover';
    }


    use HasFactory;
}
