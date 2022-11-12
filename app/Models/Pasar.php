<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasar extends Model
{
    protected $table = 'tb_pasar';
    protected $guarded = [];

    public function lokasi(){
        return $this->belongsTo(Lokasi::class, 'id_desa');
    }

    use HasFactory;
}
