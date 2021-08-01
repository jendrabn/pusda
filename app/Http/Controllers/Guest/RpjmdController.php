<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\FiturRpjmd;
use App\Models\IsiRpjmd;
use App\Models\TabelRpjmd;
use App\Models\UraianRpjmd;

class RpjmdController extends Controller
{
    public function index()
    {
        $categories = TabelRpjmd::with('childs.childs.childs')->where('parent_id', 1)->get();
        return view('guest.rpjmd', compact('categories'));
    }
    public function table($id)
    {
        $tabelRpjmd = TabelRpjmd::findOrFail($id);
        $uraianRpjmd = UraianRpjmd::getUraianByTableId($id);
        $fiturRpjmd = FiturRpjmd::getFiturByTableId($id);
        $years = IsiRpjmd::getYears($id);

        return view('guest.tables.rpjmd', compact('tabelRpjmd', 'uraianRpjmd',  'fiturRpjmd',  'years'));
    }

    public function getUraianForChart($id)
    {
        $uraianRpjmd = UraianRpjmd::findOrFail($id);
        $isiRpjmd = $uraianRpjmd
            ->isiRpjmd()
            ->orderByDesc('tahun')
            ->groupBy('tahun')
            ->get(['tahun', 'isi']);

        $response = [
            'uraian_id' => $uraianRpjmd->id,
            'uraian_parent_id' => $uraianRpjmd->parent_id,
            'uraian' => $uraianRpjmd->uraian,
            'satuan' => $uraianRpjmd->satuan,
            'isi' =>  $isiRpjmd,
            'ketersedian_data' => $uraianRpjmd->ketersediaan_data
        ];

        return response()->json($response);
    }
}
