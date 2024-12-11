<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisKompenModel extends Model
{
    use HasFactory;

    protected $table = 'm_jenis_kompen'; // Mendefinisikan nama tabel

    protected $primaryKey = 'id_jenis_kompen'; // Mendefinisikan primary key

    protected $fillable = ['jenis_kompen'];

    public function tugasadmin(): HasMany
    {
        return $this->hasMany(TugasAdminModel::class, 'id_jenis_kompen', 'id_jenis_kompen');
    }
}
