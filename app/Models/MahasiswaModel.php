<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MahasiswaModel extends Model
{
    use HasFactory;

    protected $table = 'm_mahasiswa'; // Mendefinisikan nama tabel
    protected $primaryKey = 'id_mahasiswa'; // Mendefinisikan primary key

    protected $fillable = ['id_level', 'username', 'password', 'nim', 'prodi', 'email', 'tahun_masuk', 'no_telepon', 'nama', 'avatar'];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];

    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'id_level', 'id_level');
    }

    public function getRoleName(): string
    {
        return $this->level->level_nama;
    }

    public function hasRole($role): bool
    {
        return $this->level->level_kode == $role;
    }

    public function getRole()
    {
        return $this->level->level_kode;
    }
}
