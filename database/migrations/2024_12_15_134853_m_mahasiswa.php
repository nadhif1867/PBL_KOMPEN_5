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
        Schema::create('m_mahasiswa', function (Blueprint $table) {
            $table->id('id_mahasiswa');
            $table->unsignedBigInteger('id_level')->index();
            $table->string('username');
            $table->string('password');
            $table->string('nim');
            $table->string('prodi');
            $table->string('email');
            $table->integer('tahun_masuk');
            $table->string('nama');
            $table->string('no_telepon');
            $table->string('avatar')->nullable();
            $table->string('kelas')->nullable();
            $table->string('semester')->nullable();
            $table->timestamps();

            $table->foreign('id_level')->references('id_level')->on('m_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_mahasiswa');
    }
};
