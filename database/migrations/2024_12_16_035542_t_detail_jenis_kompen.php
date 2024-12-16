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
        Schema::create('t_detail_jenis_kompen', function (Blueprint $table) {
            $table->id('id_detail_jenis_kompen');
            $table->unsignedBigInteger('id_bidkom')->index();
            $table->unsignedBigInteger('id_jenis_kompen')->index();
            $table->timestamps();

            $table->foreign('id_bidkom')->references('id_bidkom')->on('m_bidang_kompetensi');
            $table->foreign('id_jenis_kompen')->references('id_jenis_kompen')->on('m_jenis_kompen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_detail_jenis_kompen');
    }
};
