<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MahasiswaModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_mahasiswa'; // Mendefinisikan nama tabel
    protected $primaryKey = 'id_mahasiswa'; // Mendefinisikan primary key

    protected $fillable = ['id_level', 'username', 'password', 'nim', 'prodi', 'email','kelas', 'semester', 'tahun_masuk', 'no_telepon', 'nama', 'avatar'];

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

    public function getAuthIdentifierName()
    {
        return 'id_mahasiswa';
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return null; // Jika tidak digunakan
    }

    public function setRememberToken($value)
    {
        // Tidak perlu diimplementasikan jika tidak digunakan
    }

    public function getRememberTokenName()
    {
        return null; // Jika tidak digunakan
    }
}
