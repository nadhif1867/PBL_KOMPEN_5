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
        Schema::create('t_riwayat_kompen', function (Blueprint $table) {
            $table->id('id_riwayat');
            $table->enum('status', array('diterima', 'belum_diterima'));
            $table->string('file_upload')->nullable();
            $table->unsignedBigInteger('id_progres_tugas')->index();
            $table->unsignedBigInteger('id_tugas_kompen')->index();
            $table->timestamps();

            $table->foreign('id_progres_tugas')->references('id_progres_tugas')->on('t_progres_tugas');
            $table->foreign('id_tugas_kompen')->references('id_tugas_kompen')->on('m_tugas_kompen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_riwayat_kompen');
    }
};
