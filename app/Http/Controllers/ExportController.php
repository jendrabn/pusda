<?php

namespace App\Http\Controllers;

use App\Exports\BpsExport;
use App\Exports\DelapanKelDataExport;
use App\Exports\IndikatorExport;
use App\Exports\RpjmdExport;
use App\Models\Tabel8KelData;
use App\Models\TabelBps;
use App\Models\TabelIndikator;
use App\Models\TabelRpjmd;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportRpjmd(TabelRpjmd $tabelRpjmd)
    {
        $fileName = "Tabel RPJMD {$tabelRpjmd->nama_menu}.{$this->getFormat()}";
        return Excel::download(new RpjmdExport($tabelRpjmd->id), $fileName);
    }

    public function exportBps(TabelBps $tabelBps)
    {
        $fileName = "Tabel BPS {$tabelBps->nama_menu}.{$this->getFormat()}";
        return Excel::download(new BpsExport($tabelBps->id), $fileName);
    }

    public function export8KelData(Tabel8KelData $tabel8KelData)
    {
        $fileName = "Tabel 8 Kelompok Data {$tabel8KelData->nama_menu}.{$this->getFormat()}";
        return Excel::download(new DelapanKelDataExport($tabel8KelData->id), $fileName);
    }

    public function exportIndikator(TabelIndikator $tabelIndikator)
    {
        $fileName = "Tabel Indikator {$tabelIndikator->nama_menu}.{$this->getFormat()}";
        return Excel::download(new IndikatorExport($tabelIndikator->id), $fileName);
    }

    private function getFormat()
    {
        $format = request()->input('format');
        if (!in_array($format, ['xlsx', 'csv', 'xls'])) {
            $format = 'xlsx';
        }
        return $format;
    }
}
