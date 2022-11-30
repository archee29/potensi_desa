<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $table = 'tb_lokasi';

    protected $fillable = ['nama_desa','image', 'location','keterangan'];

    public function getImage(){
        if(substr($this->image,0, 5)=="https"){
            return $this->image;
        }
        if($this->image){
            return asset('/images/Poto-Kalimas/desa/' . $this->image);
        }
        return 'https://via.placeholder.com/500x500.png?text=No+Cover';
    }

    // public function sekolah(){
    //     return $this->hasMany(Sekolah::class, 'id');
    // }

    // public function tempatibadah(){
    //     return $this->belongsTo(RumahIbadah::class, 'id');
    // }
    // public function pasar(){
    //     return $this->belongsTo(Pasar::class, 'id');
    // }

    // public function tempatwisata(){
    //     return $this->belongsTo(TempatWisata::class, 'id');
    // }

    // public function kecamatan(){
    //     return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    // }

    use HasFactory;
}
