<?php

namespace App\Http\Controllers\Front;


use App\Http\Controllers\Controller;
use App\Models\FiturIndikator;
use App\Models\IsiIndikator;
use App\Models\TabelIndikator;
use App\Models\UraianIndikator;

class IndikatorController extends Controller
{
    public function index()
    {
        $categories = TabelIndikator::with('childs.childs.childs')->where('parent_id', 1)->get();
        return view('front.indikator', compact('categories'));
    }
    public function table($id)
    {
        $tabelIndikator = TabelIndikator::findOrFail($id);
        $uraianIndikator = UraianIndikator::getUraianByTableId($id);
        $fiturIndikator = FiturIndikator::getFiturByTableId($id);
        $years = IsiIndikator::getYears($id);

        return view('front.tables.indikator', compact('tabelIndikator', 'uraianIndikator',  'fiturIndikator',  'years'));
    }

    public function getUraianForChart($id)
    {
        $uraianIndikator = UraianIndikator::findOrFail($id);
        $isiIndikator = $uraianIndikator
            ->isiIndikator()
            ->orderByDesc('tahun')
            ->groupBy('tahun')
            ->get(['tahun', 'isi']);

        $response = [
            'uraian_id' => $uraianIndikator->id,
            'uraian_parent_id' => $uraianIndikator->parent_id,
            'uraian' => $uraianIndikator->uraian,
            'satuan' => $uraianIndikator->satuan,
            'isi' =>  $isiIndikator,
            'ketersedian_data' => $uraianIndikator->ketersediaan_data
        ];

        return response()->json($response);
    }
}
