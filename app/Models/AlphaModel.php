<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlphaModel extends Model
{
    use HasFactory;

    protected $table = 'm_alpha'; // Mendefinisikan nama tabel

    protected $primaryKey = 'id_alpha'; // Mendefinisikan primary key

    protected $fillable = ['id_mahasiswa', 'jumlah_alpha', 'id_periode'];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(MahasiswaModel::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(PeriodeAkademikModel::class, 'id_periode', 'id_periode');
    }
}
