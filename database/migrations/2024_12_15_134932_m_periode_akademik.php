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
        Schema::create('m_periode_akademik', function (Blueprint $table) {
            $table->id('id_periode');
            $table->enum('semester', array('ganjil', 'genap'));
            $table->integer('tahun_ajaran');
            $table->enum('status', array('dibuka', 'ditutup'))->default('dibuka');;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_periode_akademik');
    }
};
