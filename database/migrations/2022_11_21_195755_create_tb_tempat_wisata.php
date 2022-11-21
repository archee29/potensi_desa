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
        Schema::create('tb_tempat_wisata', function (Blueprint $table) {
            $table->id();
            $table->string('author');
            $table->string('dusun');
            $table->string('slug');
            $table->string('nama_wisata');
            $table->longText('keterangan');
            $table->string('location');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('tb_tempat_wisata');
    }
};
