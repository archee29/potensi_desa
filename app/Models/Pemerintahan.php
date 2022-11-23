<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemerintahan extends Model
{
    protected $table = 'tb_pemerintahan';
    protected $guarded = [];

    // public function jenispotensi(){
    //     return $this->hasMany(JenisPotensi::class, 'id_potensi');
    // }

    public function getImage(){
        if(substr($this->image,0,5)=="https"){
            return $this->image;
        }
        if($this->image){
            return asset('/images/Poto-Kalimas/Pemerintahan/'.$this->image);
        }
        return 'https://via.placeholder.com/500x500.png?text=No+Cover';
    }
    use HasFactory;
}
