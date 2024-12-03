<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LevelModel extends Model
{
    use HasFactory;

    protected $table = 'm_level'; // Mendefinisikan nama tabel
    protected $primaryKey = 'id_level'; // Mendefinisikan primary key

    protected $fillable = ['kode_level', 'nama_level'];
    public function mahasiswa(): HasMany
    {
        return $this->hasMany(MahasiswaModel::class, 'id_level', 'id_level');
    }

    public function admin(): HasMany
    {
        return $this->hasMany(AdminModel::class, 'id_level', 'id_level');
    }

    public function dosen(): HasMany
    {
        return $this->hasMany(DosenModel::class, 'id_level', 'id_level');
    }

    public function tendik(): HasMany
    {
        return $this->hasMany(TendikModel::class, 'id_level', 'id_level');
    }
}
