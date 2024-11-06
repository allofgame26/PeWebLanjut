<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_mata_kuliah', function (Blueprint $table){
            $table->id('id_mk');
            $table->string('nama_mk',20);
            $table->string('kode_mk',5);
            $table->string('deskripsi_mk',30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_mata_kuliah');
    }
};