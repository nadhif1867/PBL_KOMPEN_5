<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProgresTugasModel;
use App\Models\TugasKompenModel;
use Illuminate\Http\Request;

class TugasKompenController extends Controller
{
    public function progresMahasiswa(Request $request)
    {
        // Ambil parameter username dari request
        $username = $request->input('username');

        // Query data m_tugas_kompen dengan relasi mahasiswa dan progres
        $progres = TugasKompenModel::with([
            'mahasiswa',
            'progresTugas',
            'tugasadmin.pemberiTugas',
            'tugasdosen.pemberiTugas',
            'tugastendik.pemberiTugas',
            'tugasadmin.bidangKompetensi',
            'tugasdosen.bidangKompetensi',
            'tugastendik.bidangKompetensi',
            'tugasadmin.jenisPenugasanAdmin',
            'tugasdosen.jenisPenugasanDosen',
            'tugastendik.jenisPenugasanTendik',
        ])
            ->when($username, function ($query) use ($username) {
                $query->whereHas('mahasiswa', function ($q) use ($username) {
                    $q->where('username', $username);
                });
            })
            ->get();

        // Format data untuk response JSON
        $formattedProgres = $progres->map(function ($item) {
            $fallback = null;
            return [
                'id_tugas_kompen' => $item->id_tugas_kompen ?? $fallback,
                'username' => optional($item->mahasiswa)->username ?? $fallback,
                'progress' => optional($item->progresTugas)->pluck('progress')->toArray() ?: [$fallback],

                'tugas' => [
                    'dosen' => [
                        'nama_tugas' => optional($item->tugasdosen)->nama_tugas ?? $fallback,
                        'deskripsi' => optional($item->tugasdosen)->deskripsi ?? $fallback,
                        'jam_kompen' => optional($item->tugasdosen)->jam_kompen ?? $fallback,
                        'kuota' => optional($item->tugasdosen)->kuota ?? $fallback,
                        'pemberiTugas' => $item->tugasdosen->pemberiTugas->username ?? $fallback,
                        'id_dosen' => optional($item->tugasdosen)->id_dosen ?? $fallback,
                        'bidangKompetensi' => [
                            'nama_bidkom' => $item->tugasdosen->bidangKompetensi->nama_bidkom ?? $fallback,
                            'id_bidkom' => $item->tugasdosen->bidangKompetensi->id_bidkom ?? $fallback,
                        ],
                        'jenisPenugasanDosen' => [
                            'jenis_kompen' => $item->tugasdosen->jenisPenugasanDosen->jenis_kompen ?? $fallback,
                            'id_jenis_kompen' => $item->tugasdosen->jenisPenugasanDosen->id_jenis_kompen ?? $fallback,
                        ],
                    ],
                    'admin' => [
                        'nama_tugas' => $item->tugasadmin->nama_tugas ?? $fallback,
                        'deskripsi' => optional($item->tugasadmin)->deskripsi ?? $fallback,
                        'jam_kompen' => optional($item->tugasadmin)->jam_kompen ?? $fallback,
                        'kuota' => optional($item->tugasadmin)->kuota ?? $fallback,
                        'pemberiTugas' => $item->tugasadmin->pemberiTugas->username ?? $fallback,
                        'id_admin' => optional($item->tugasadmin)->id_admin ?? $fallback,
                        'bidangKompetensi' => [
                            'nama_bidkom' => $item->tugasadmin->bidangKompetensi->nama_bidkom ?? $fallback,
                            'id_bidkom' => $item->tugasadmin->bidangKompetensi->id_bidkom ?? $fallback
                        ],
                        'jenisPenugasanAdmin' => [
                            'jenis_kompen' => $item->tugasadmin->jenisPenugasanAdmin->jenis_kompen ?? $fallback,
                            'id_jenis_kompen' => $item->tugasadmin->jenisPenugasanAdmin->id_jenis_kompen ?? $fallback
                        ]
                    ],
                    'tendik' => [
                        'nama_tugas' => optional($item->tugastendik)->nama_tugas ?? $fallback,
                        'deskripsi' => optional($item->tugastendik)->deskripsi ?? $fallback,
                        'jam_kompen' => optional($item->tugastendik)->jam_kompen ?? $fallback,
                        'kuota' => optional($item->tugastendik)->kuota ?? $fallback,
                        'pemberiTugas' => $item->tugastendik->pemberiTugas->username ?? $fallback,
                        'id_tendik' => optional($item->tugastendik)->id_tendik ?? $fallback,
                        'bidangKompetensi' => [
                            'nama_bidkom' => $item->tugastendik->bidangKompetensi->nama_bidkom ?? $fallback,
                            'id_bidkom' => $item->tugastendik->bidangKompetensi->id_bidkom ?? $fallback
                        ],
                        'jenisPenugasanTendik' => [
                            'jenis_kompen' => $item->tugastendik->jenisPenugasanTendik->jenis_kompen ?? $fallback,
                            'id_jenis_kompen' => $item->tugastendik->jenisPenugasanTendik->id_jenis_kompen ?? $fallback
                        ]
                    ]

                ]
            ];
        });

        // Response JSON
        return response()->json([
            'success' => true,
            'data' => $formattedProgres,
        ]);
    }
}
