<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdminModel extends Model
{
    use HasFactory;

    protected $table = 'm_admin'; // Mendefinisikan nama tabel

    protected $primaryKey = 'id_admin'; // Mendefinisikan primary key

    protected $fillable = ['id_level', 'username', 'password', 'nip', 'no_telepon', 'email', 'nama', 'avatar'];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];

    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'id_level', 'id_level');
    }

    // public function tugas(): HasMany {
    //     return $this->hasMany()
    // }

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
