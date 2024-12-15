<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasKompenModel extends Model
{
    use HasFactory;

    protected $table = 'm_tugas_kompen';
    protected $primaryKey = 'id_tugas_kompen';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'id_tugas_admin',
        'id_tugas_dosen',
        'id_tugas_tendik',
        'id_mahasiswa',
        'status_penerimaan',
        'tanggal_apply',
        'created_at', 
        'updated_at'
    ];

    // Relasi
    public function tugasadmin()
    {
        return $this->belongsTo(TugasAdminModel::class, 'id_tugas_admin', 'id_tugas_admin');
    }

    public function tugasdosen()
    {
        return $this->belongsTo(TugasDosenModel::class, 'id_tugas_dosen', 'id_tugas_dosen');
    }

    public function tugastendik()
    {
        return $this->belongsTo(TugasTendikModel::class, 'id_tugas_tendik', 'id_tugas_tendik');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'id_mahasiswa', 'id_mahasiswa');
    }
}

