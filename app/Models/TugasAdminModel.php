<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TugasAdminModel extends Model
{
    use HasFactory;

    protected $table = 'tugas_admin'; // Mendefinisikan nama tabel

    protected $primaryKey = 'id_tugas_admin'; // Mendefinisikan primary key

    protected $fillable = ['nama_tugas', 'deskripsi', 'status', 'tanggal_mulai', 'tanggal_selesai', 'jam_kompen', 'kuota', 'id_bidkom', 'id_jenis_kompen', 'id_admin', 'create_at', 'update_at', 'id_periode'];
    public function admin(): BelongsTo
    {
        return $this->belongsTo(AdminModel::class, 'id_admin', 'id_admin');
    }

    public function jeniskompen(): BelongsTo
    {
        return $this->belongsTo(JenisKompenModel::class, 'id_jenis_kompen', 'id_jenis_kompen');
    }

    public function bidangkompetensi(): BelongsTo
    {
        return $this->belongsTo(BidangKompetensiModel::class, 'id_bidkom', 'id_bidkom');
    }

    public function periodeAkademik(): BelongsTo
    {
        return $this->belongsTo(PeriodeAkademikModel::class, 'id_periode', 'id_periode');
    }
}
