<?php

namespace App\Http\Controllers;

use App\Models\PeriodeAkademikModel;
use App\Models\TugasKompenModel;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class aReportKompenController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Report Kompen',
            'list' => ['Home', 'Report Kompen']
        ];

        $page = (object)[
            'title' => 'Report'
        ];

        $activeMenu = 'aReportKompen';

        $data = PeriodeAkademikModel::select('id_periode', 'semester', 'tahun_ajaran')
            ->orderBy('tahun_ajaran', 'asc')
            ->get();

        return view('aReportKompen.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'data' => $data

        ]);
    }


    public function exportPDF($id_periode)
{
    $periode = PeriodeAkademikModel::findOrFail($id_periode);

    $dataPresensi = TugasKompenModel::leftJoin('t_riwayat_kompen', 'm_tugas_kompen.id_tugas_kompen', '=', 't_riwayat_kompen.id_tugas_kompen')
        ->leftJoin('m_mahasiswa', 'm_tugas_kompen.id_mahasiswa', '=', 'm_mahasiswa.id_mahasiswa')
        ->leftJoin('tugas_admin', 'm_tugas_kompen.id_tugas_admin', '=', 'tugas_admin.id_tugas_admin')
        ->leftJoin('m_admin', 'tugas_admin.id_admin', '=', 'm_admin.id_admin')
        ->leftJoin('tugas_dosen', 'm_tugas_kompen.id_tugas_dosen', '=', 'tugas_dosen.id_tugas_dosen')
        ->leftJoin('m_dosen', 'tugas_dosen.id_dosen', '=', 'm_dosen.id_dosen')
        ->leftJoin('tugas_tendik', 'm_tugas_kompen.id_tugas_tendik', '=', 'tugas_tendik.id_tugas_tendik')
        ->leftJoin('m_tendik', 'tugas_tendik.id_tendik', '=', 'm_tendik.id_tendik')
        ->select(
            'm_tugas_kompen.id_tugas_kompen',
            'm_mahasiswa.nim',
            'm_mahasiswa.nama as nama_mahasiswa',
            't_riwayat_kompen.status',
            DB::raw('COALESCE(tugas_admin.nama_tugas, tugas_dosen.nama_tugas, tugas_tendik.nama_tugas) as nama_tugas'),
            DB::raw('COALESCE(tugas_admin.jam_kompen, tugas_dosen.jam_kompen, tugas_tendik.jam_kompen) as jumlah_jam'),
            DB::raw('COALESCE(tugas_admin.tanggal_mulai, tugas_dosen.tanggal_mulai, tugas_tendik.tanggal_mulai) as tanggal_mulai'),
            DB::raw('COALESCE(tugas_admin.tanggal_selesai, tugas_dosen.tanggal_selesai, tugas_tendik.tanggal_selesai) as tanggal_selesai'),
            DB::raw('COALESCE(m_admin.nama, m_dosen.nama, m_tendik.nama) as pemberi_tugas')
        )
        ->where('m_tugas_kompen.status_penerimaan', 'diterima')
        ->whereNotNull('t_riwayat_kompen.status')
        ->where(function ($query) use ($id_periode) {
            $query->where('tugas_admin.id_periode', $id_periode)
                ->orWhere('tugas_dosen.id_periode', $id_periode)
                ->orWhere('tugas_tendik.id_periode', $id_periode);
        })
        ->get();

    // Generate PDF
    $pdf = Pdf::loadView('aReportKompen.export_report', [
        'dataPresensi' => $dataPresensi,
        'tanggalCetak' => now()->format('d-m-Y'),
        'periode' => "{$periode->semester} - {$periode->tahun_ajaran}"
    ]);

    return $pdf->download("Laporan_Kompensasi_{$periode->semester}_{$periode->tahun_ajaran}.pdf");
}

}
