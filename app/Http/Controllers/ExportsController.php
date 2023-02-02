<?php

namespace App\Http\Controllers;

use App\Exports\IsiUraianExport;
use App\Models\Tabel8KelData;
use App\Models\TabelBps;
use App\Models\TabelIndikator;
use App\Models\TabelRpjmd;
use App\Services\BpsService;
use App\Services\DelapanKelDataService;
use App\Services\IndikatorService;
use App\Services\RpjmdService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class ExportsController extends Controller
{

  public function __construct(Request $request)
  {
    $request->validate([
      'format' => ['required', 'in:xlsx,csv,xls']
    ]);
  }

  public function export8KelData(Tabel8KelData $tabel)
  {
    $service = new DelapanKelDataService();
    $uraians = $service->getAllUraianByTabelId($tabel);
    $tahuns = $service->getAllTahun($tabel);
    $fitur = $tabel->fitur8KelData->first();
    $crudRoutePart = 'delapankeldata';
    $fileName = $this->formatFileName($tabel->nama_menu, '8 Kelompok Data');

    return Excel::download(new IsiUraianExport($crudRoutePart, $fitur, $uraians, $tahuns), $fileName);
  }

  public function exportRpjmd(TabelRpjmd $tabel)
  {
    $service = new RpjmdService();
    $uraians = $service->getAllUraianByTabelId($tabel);
    $tahuns = $service->getAllTahun($tabel);
    $fitur = $tabel->fiturRpjmd->first();
    $crudRoutePart = 'rpjmd';
    $fileName = $this->formatFileName($tabel->nama_menu, 'RPJMD');

    return Excel::download(new IsiUraianExport($crudRoutePart, $fitur, $uraians, $tahuns), $fileName);
  }

  public function exportBps(TabelBps $tabel)
  {
    $service = new BpsService();
    $uraians = $service->getAllUraianByTabelId($tabel);
    $tahuns = $service->getAllTahun($tabel);
    $fitur = $tabel->fiturBps->first();
    $crudRoutePart = 'bps';
    $fileName = $this->formatFileName($tabel->nama_menu, 'BPS');

    return Excel::download(new IsiUraianExport($crudRoutePart, $fitur, $uraians, $tahuns), $fileName);
  }

  public function exportIndikator(TabelIndikator $tabel)
  {
    $service = new IndikatorService();
    $uraians = $service->getAllUraianByTabelId($tabel);
    $tahuns = $service->getAllTahun($tabel);
    $fitur = $tabel->fiturIndikator->first();
    $crudRoutePart = 'indikator';
    $fileName = $this->formatFileName($tabel->nama_menu, 'Indikator');

    return Excel::download(new IsiUraianExport($crudRoutePart, $fitur, $uraians, $tahuns), $fileName);
  }

  private function formatFileName(string $namaTabel, string $namaMenu)
  {
    return sprintf('%s.%s', Str::snake(sprintf('tabel %s_%s', $namaTabel, $namaMenu), '_'), request('format'));
  }
}
