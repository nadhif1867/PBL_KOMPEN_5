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
        Schema::create('tugas_dosen', callback: function (Blueprint $table) {
            $table->id('id_tugas_dosen');
            $table->string('nama_tugas');
            $table->string('deskripsi');
            $table->enum('status', array('dibuka', 'selesai', 'ditutup'));
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->integer('jam_kompen');
            $table->integer('kuota');
            $table->unsignedBigInteger('id_bidkom')->index();
            $table->unsignedBigInteger('id_jenis_kompen')->index();
            $table->unsignedBigInteger('id_dosen')->index();
            $table->unsignedBigInteger('id_periode')->index();
            $table->timestamps();

            $table->foreign('id_bidkom')->references('id_bidkom')->on('m_bidang_kompetensi');
            $table->foreign('id_jenis_kompen')->references('id_jenis_kompen')->on('m_jenis_kompen');
            $table->foreign('id_dosen')->references('id_dosen')->on('m_dosen');
            $table->foreign('id_periode')->references('id_periode')->on('m_periode_akademik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_dosen');
    }
};
