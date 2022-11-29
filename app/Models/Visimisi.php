<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visimisi extends Model
{
    protected $table = 'tb_visimisi';
    protected $guarded = [];

    // public function jenispotensi(){
    //     return $this->hasMany(JenisPotensi::class, 'id_potensi');
    // }

    public function getImage()
    {
        if (substr($this->image, 0, 5) == "https") {
            return $this->image;
        }
        if ($this->image) {
            return asset('images/poto-kalimas/visimisi/' . $this->image);
        }
        return 'https://via.placeholder.com/500x500.png?text=No+Cover';
    }
    use HasFactory;
}
