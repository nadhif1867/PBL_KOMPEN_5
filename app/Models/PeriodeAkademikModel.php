<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeriodeAkademikModel extends Model
{
    use HasFactory;

    protected $table = 'm_periode_akademik'; // Mendefinisikan nama tabel
    protected $primaryKey = 'id_periode'; // Mendefinisikan primary key

    protected $fillable = ['semester', 'tahun_ajaran'];
    public function periode(): HasMany
    {
        return $this->hasMany(AlphaModel::class, 'id_periode', 'id_periode');
    }
}
