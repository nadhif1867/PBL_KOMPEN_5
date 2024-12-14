<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKompenModel extends Model
{
    use HasFactory;

    protected $table = 't_riwayat_kompen';
    protected $primaryKey = 'id_riwayat';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_riwayat',
        'id_tugas_kompen',
        'id_progres_tugas',
        'status',
        'file_upload',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship to TugasKompenModel
    public function tugasKompen()
    {
        return $this->belongsTo(TugasKompenModel::class, 'id_tugas_kompen');
    }

    // Corrected relationship to ProgresTugasModel
    public function progresTugas()
    {
        return $this->belongsTo(ProgresTugasModel::class, 'id_progres_tugas');
    }
}
