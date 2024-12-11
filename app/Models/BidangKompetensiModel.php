<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BidangKompetensiModel extends Model
{
    use HasFactory;

    protected $table = 'm_bidang_kompetensi'; // Mendefinisikan nama tabel

    protected $primaryKey = 'id_bidkom'; // Mendefinisikan primary key

    protected $fillable = ['nama_bidkom', 'tag_bidkom'];

    public function detailbidkom(): HasMany
    {
        return $this->hasMany(DetailBidKomModel::class, 'id_bidkom', 'id_bidkom');
    }

    public function detailjekom(): HasMany
    {
        return $this->hasMany(DetailJenisKompenModel::class, 'id_bidkom', 'id_bidkom');
    }

}
