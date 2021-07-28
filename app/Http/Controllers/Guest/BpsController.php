<?php

namespace App\Http\Controllers\Guest;

use App\Exports\BpsExport;
use App\Http\Controllers\Controller;
use App\Models\FiturBps;
use App\Models\IsiBps;
use App\Models\TabelBps;
use App\Models\UraianBps;
use Maatwebsite\Excel\Facades\Excel;

class BpsController extends Controller
{
    public function index()
    {
        $categories = TabelBps::where('parent_id', 1)->get();
        return view('guest.bps', compact('categories'));
    }

    public function table($id)
    {
        $tabelBps = TabelBps::findOrFail($id);
        $uraianBps = UraianBps::getUraianByTableId($id);
        $fiturBps = FiturBps::getFiturByTableId($id);
        $years = IsiBps::getYears();

        return view('guest.tables.bps', compact('tabelBps', 'uraianBps',  'fiturBps',  'years'));
    }

    public function export($id)
    {
        $tabelBps = TabelBps::findOrFail($id);
        $format = request()->input('format');
        if (!in_array($format, ['xlsx', 'csv', 'xls'])) {
            $format = 'xlsx';
        }

        $fileName = "BPS-{$tabelBps->nama_menu}.{$format}";
        return Excel::download(new BpsExport($id), $fileName);
    }

    public function getUraianForChart($id)
    {
        $uraianBps = UraianBps::findOrFail($id);
        $isiBps = $uraianBps
            ->isiBps()
            ->orderByDesc('tahun')
            ->groupBy('tahun')
            ->take(5)
            ->get(['tahun', 'isi']);

        $response = [
            'uraian_id' => $uraianBps->id,
            'uraian_parent_id' => $uraianBps->parent_id,
            'uraian' => $uraianBps->uraian,
            'satuan' => $uraianBps->satuan,
            'isi' =>  $isiBps,
            'ketersedian_data' => $uraianBps->ketersediaan_data
        ];

        return response()->json($response);
    }

    public function getSummaryUraianForChart($id)
    {
        $t = IsiBps::limit(5)->groupBy('tahun')->get(['tahun'])->sortBy('tahun');
        $tabel = TabelBps::where('id', $id)->first();
        $n = 1;
        $mm = 1;
        foreach ($t as $tahun) {
            $thn = IsiBps::query()
                ->leftJoin('uraian_bps', 'uraian_bps.id', 'isi_bps.uraian_bps_id')
                ->leftJoin('tabel_bps', 'tabel_bps.id', 'uraian_bps.tabel_bps_id')
                ->where('isi_bps.tahun', $tahun->tahun)
                ->where('tabel_bps.id', $id)
                ->sum('isi_bps.isi');
            ${'ket' . $mm++} = $tahun->tahun;
            ${'d' . $n++} = $thn;
        }

        return response()->json([
            "nama" => $tabel->nama_menu,
            "label" => [$ket1, $ket2, $ket3, $ket4, $ket5],
            "data" => [$d1, $d2, $d3, $d4, $d5]
        ]);
    }
}
