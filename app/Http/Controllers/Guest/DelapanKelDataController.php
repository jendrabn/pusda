<?php

namespace App\Http\Controllers\Guest;

use App\Exports\DelapanKelDataExport;
use App\Http\Controllers\Controller;
use App\Models\Fitur8KelData;
use App\Models\Isi8KelData;
use App\Models\Tabel8KelData;
use App\Models\Uraian8KelData;
use Maatwebsite\Excel\Facades\Excel;

class DelapanKelDataController extends Controller
{
    public function index()
    {
        $categories = Tabel8KelData::where('parent_id', 1)->get();
        return view('guest.delapankeldata', compact('categories'));
    }

    public function table($id)
    {
        $tabel8KelData = Tabel8KelData::findOrFail($id);
        $uraian8KelData = Uraian8KelData::getUraianByTableId($id);
        $fitur8KelData = Fitur8KelData::getFiturByTableId($id);
        $years = Isi8KelData::getYears();

        return view('guest.tables.delapankeldata', compact('tabel8KelData',  'uraian8KelData',  'fitur8KelData',  'years'));
    }

    public function export($id)
    {
        $tabel8KelData = Tabel8KelData::findOrFail($id);
        $format = request()->input('format');
        if (!in_array($format, ['xlsx', 'csv', 'xls'])) {
            $format = 'xlsx';
        }

        $fileName = "8-Kelompok-Data-{$tabel8KelData->nama_menu}.{$format}";

        return Excel::download(new DelapanKelDataExport($id), $fileName);
    }

    public function getUraianForChart($id)
    {
        $uraian8KelData = Uraian8KelData::findOrFail($id);
        $isi8KelData = $uraian8KelData
            ->isi8KelData()
            ->orderByDesc('tahun')
            ->groupBy('tahun')
            ->take(5)
            ->get(['tahun', 'isi']);

        $response = [
            'uraian_id' => $uraian8KelData->id,
            'uraian_parent_id' => $uraian8KelData->parent_id,
            'uraian' => $uraian8KelData->uraian,
            'satuan' => $uraian8KelData->satuan,
            'isi' =>  $isi8KelData,
            'ketersedian_data' => $uraian8KelData->ketersediaan_data
        ];

        return response()->json($response);
    }
}
