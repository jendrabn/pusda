<?php

namespace App\Exports;

use App\Models\File8KelData;
use App\Models\Fitur8KelData;
use App\Models\Isi8KelData;
use App\Models\Uraian8KelData;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DelapanKelDataExport implements FromView, ShouldAutoSize
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }


    public function view(): View
    {
        $uraian8KelData = Uraian8KelData::getUraianByTableId($this->id);
        $fitur8Keldata = Fitur8KelData::getFiturByTableId($this->id);
        $files = File8KelData::where('tabel_8keldata_id',  $this->id)->get();
        $years = Isi8KelData::getYears();

        return view('exports.8keldata', compact('uraian8KelData', 'fitur8Keldata', 'files', 'years'));
    }
}
