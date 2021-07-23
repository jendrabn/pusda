<?php

namespace App\Http\Controllers\Guest;

use App\Exports\RpjmdExport;
use App\Http\Controllers\Controller;
use App\Models\FileRpjmd;
use App\Models\FiturRpjmd;
use App\Models\IsiRpjmd;
use App\Models\Skpd;
use App\Models\TabelRpjmd;
use App\Models\UraianRpjmd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;

class RpjmdController extends Controller
{
    public function index()
    {
        $categories = TabelRpjmd::where('parent_id', 1)->get();
        return view('guest.rpjmd', compact('categories'));
    }
    public function table($id)
    {
        $tabelRpjmd = TabelRpjmd::findOrFail($id);
        $uraianRpjmd = UraianRpjmd::getUraianByTableId($id);
        $fiturRpjmd = FiturRpjmd::getFiturByTableId($id);
        $years = IsiRpjmd::getYears();

        return view('guest.tables.rpjmd', compact('tabelRpjmd', 'uraianRpjmd',  'fiturRpjmd',  'years'));
    }

    public function export($id)
    {
        $tabelRpjmd = TabelRpjmd::findOrFail($id);
        $format = request()->input('format');
        if (!in_array($format, ['xlsx', 'csv', 'xls'])) {
            $format = 'xlsx';
        }

        $fileName = "RPJMD-{$tabelRpjmd->menu_name}.{$format}";

        return Excel::download(new RpjmdExport($id), $fileName);
    }

    public function getUraianForChart($id)
    {
        $uraianRpjmd = UraianRpjmd::findOrFail($id);
        $isiRpjmd = $uraianRpjmd
            ->isiRpjmd()
            ->orderByDesc('tahun')
            ->groupBy('tahun')
            ->take(5)
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
