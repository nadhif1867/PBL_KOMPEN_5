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
        Schema::create('m_tugas_kompen', function (Blueprint $table) {
            $table->id('id_tugas_kompen');
            $table->unsignedBigInteger('id_mahasiswa')->index();
            $table->unsignedBigInteger('id_tugas_admin')->nullable()->index();
            $table->unsignedBigInteger('id_tugas_dosen')->nullable()->index();
            $table->unsignedBigInteger('id_tugas_tendik')->nullable()->index();
            $table->enum('status_penerimaan', array('request', 'diterima', 'dibuka'));
            $table->dateTime('tanggal_apply')->nullable();
            $table->integer('kuota')->nullable();
            $table->timestamps();

            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('m_mahasiswa');
            $table->foreign('id_tugas_admin')->references('id_tugas_admin')->on('tugas_admin')->onDelete('set null');
            $table->foreign('id_tugas_dosen')->references('id_tugas_dosen')->on('tugas_dosen')->onDelete('set null');
            $table->foreign('id_tugas_tendik')->references('id_tugas_tendik')->on('tugas_tendik')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_tugas_kompen');
    }
};
