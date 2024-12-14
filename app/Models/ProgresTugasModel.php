<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgresTugasModel extends Model
{
    use HasFactory;

    protected $table = 't_progres_tugas';

    protected $primaryKey = 'id_progres_tugas';

    public $timestamps = true;

    protected $fillable = [
        'id_progres_tugas',
        'status_progres',
        'progress',
        'id_tugas_kompen',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'id_progres_tugas' => 'integer',
        'status_progres' => 'string',
        'progress' => 'string',
        'id_tugas_kompen' => 'integer',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];

    protected $nullable = ['status_progres', 'progress'];
}
