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
        Schema::create('t_progres_tugas', function (Blueprint $table) {
            $table->id('id_progres_tugas');
            $table->enum('status_progres', array('selesai', 'progres'));
            $table->string('progress')->nullable();
            $table->unsignedBigInteger('id_tugas_kompen')->index();
            $table->timestamps();

            $table->foreign('id_tugas_kompen')->references('id_tugas_kompen')->on('m_tugas_kompen');
        });
    }

    public function down(): void
    {
        Schema::table('t_progres_tugas', function (Blueprint $table) {
            $table->dropColumn('progress');
        });

        Schema::dropIfExists('t_progres_tugas');
    }
};
