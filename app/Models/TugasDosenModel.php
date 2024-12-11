<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TugasDosenModel extends Model
{
    use HasFactory;

    protected $table = 'tugas_dosen'; // Mendefinisikan nama tabel

    protected $primaryKey = 'id_tugas_dosen'; // Mendefinisikan primary key

    protected $fillable = ['nama_tugas', 'deskripsi', 'status', 'tanggal_mulai', 'tanggal_selesai', 'jam_kompen', 'kuota', 'id_bidkom', 'id_jenis_kompen', 'id_dosen'];
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(DosenModel::class, 'id_dosen', 'id_dosen');
    }

    public function jeniskompen(): BelongsTo
    {
        return $this->belongsTo(JenisKompenModel::class, 'id_jenis_kompen', 'id_jenis_kompen');
    }

    public function bidangkompetensi(): BelongsTo
    {
        return $this->belongsTo(BidangKompetensiModel::class, 'id_bidkom', 'id_bidkom');
    }
}
