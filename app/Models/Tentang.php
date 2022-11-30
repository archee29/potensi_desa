<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tentang extends Model

{

    protected $table = 'tb_tentang';
    protected $guarded = [];

    public function getImage()
    {
        if (substr($this->image, 0, 5) == "https") {
            return $this->image;
        }
        if ($this->image) {
            return asset(
                'images/poto-kalimas/Tentang/' . $this->image
            );
        }
        return 'https://via.placeholder.com/500x500.png?text=No+Cover';
    }
    use HasFactory;
}
