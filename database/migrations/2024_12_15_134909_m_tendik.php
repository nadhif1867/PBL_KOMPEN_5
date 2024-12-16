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
        Schema::create('m_tendik', function (Blueprint $table) {
            $table->id('id_tendik');
            $table->unsignedBigInteger('id_level')->index();
            $table->string('username');
            $table->string('password');
            $table->string('nip');
            $table->string('email');
            $table->string('nama');
            $table->string('avatar');
            $table->timestamps();

            $table->foreign('id_level')->references('id_level')->on('m_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_tendik');
    }
};
