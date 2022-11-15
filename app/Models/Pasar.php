<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasar extends Model
{
    protected $table = 'tb_pasar';
    protected $guarded = [];

    public function lokasi(){
        return $this->belongsTo(Lokasi::class, 'id');
    }

    public function getImage(){
        if(substr($this->image,o,5)=="https"){
            return $this->image;
        }
        if($this->image){
            return asset('/images/Poto-Kalimas'.$this->image);
        }
        return 'https://via.placeholder.com/500x500.png?text=No+Cover';
    }

    use HasFactory;
}
