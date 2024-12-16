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
        Schema::create('t_detail_bidkom', function (Blueprint $table) {
            $table->id('id_detail_bidkom');
            $table->unsignedBigInteger('id_mahasiswa')->index();
            $table->unsignedBigInteger('id_bidkom')->index();
            $table->timestamps();

            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('m_mahasiswa');
            $table->foreign('id_bidkom')->references('id_bidkom')->on('m_bidang_kompetensi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_detail_bidkom');
    }
};
