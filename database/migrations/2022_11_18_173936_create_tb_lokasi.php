<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_lokasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_desa');
            $table->enum('jenis_potensi',['rumah_ibadah','wisata','sekolah','pasar']);
            $table->string('image')->nullable();
            $table->string('location');
            $table->longText('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_lokasi');
    }
};
