<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\FiturBps;
use App\Models\IsiBps;
use App\Models\TabelBps;
use App\Models\UraianBps;

class BpsController extends Controller
{
    public function index()
    {
        $categories = TabelBps::with('childs.childs.childs')->where('parent_id', 1)->get();

        return view('front.bps', compact('categories'));
    }

    public function table($id)
    {
        $tabelBps = TabelBps::findOrFail($id);
        $uraianBps = UraianBps::getUraianByTableId($id);
        $fiturBps = FiturBps::getFiturByTableId($id);
        $years = IsiBps::getYears($id);

        return view('front.tables.bps', compact('tabelBps', 'uraianBps',  'fiturBps',  'years'));
    }

    public function getUraianForChart($id)
    {
        $uraianBps = UraianBps::findOrFail($id);
        $isiBps = $uraianBps
            ->isiBps()
            ->orderByDesc('tahun')
            ->groupBy('tahun')
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
        $tabel = TabelBps::findOrFail($id);
        $years = IsiBps::getYears($id);

        $label = [];
        $data = [];

        foreach ($years as $year) {
            $totalIsi = IsiBps::whereHas('uraianBps.tabelBps', function ($q) use ($id) {
                $q->where('id', $id);
            })->where('tahun', $year)->sum('isi');

            array_push($label, $year);
            array_push($data, $totalIsi);
        }

        return response()->json([
            'nama' => $tabel->nama_menu,
            'label' => $label,
            'data' => $data
        ]);
    }
}
