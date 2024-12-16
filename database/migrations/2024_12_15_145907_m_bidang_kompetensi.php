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
        Schema::create('m_bidang_kompetensi', function (Blueprint $table) {
            $table->id('id_bidkom');
            $table->string('nama_bidkom');
            $table->string('tag_bidkom');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_bidang_kompetensi');
    }
};
