<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempatWisata extends Model
{
    protected $table = 'tb_wisata';
    protected $guarded=[];

    public function lokasi(){
        return $this->belongsTo(Lokasi::class, 'id');
    }

    // public function jenispotensi(){
    //     return $this->hasMany(JenisPotensi::class, 'id');
    // }
    public function getImage(){
<<<<<<< HEAD
        if(substr($this->image,5)=="https"){
=======
        if(substr($this->image,0,5)=="https"){
>>>>>>> 64c013d7f44e66cbff2b0ed1287655f7ad568af8
            return $this->image;
        }
        if($this->image){
            return asset('/images/Poto-Kalimas/wisata/' . $this->image);
        }
        return 'https://via.placeholder.com/500x500.png?text=No+Cover';
    }
    use HasFactory;
}
