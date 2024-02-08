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
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
  /**
   * Undocumented function
   *
   * @param string $namaTabel
   * @param string $namaMenu
   * @return string
   */
  private function formatFileName(string $namaTabel, string $namaMenu): string
  {
    return strtolower(implode('-', explode(' ', implode(' ', [$namaTabel, $namaMenu, date('ymd')]))) . '.xlsx');
  }

  /**
   * Undocumented function
   *
   * @param Tabel8KelData $tabel
   * @param DelapanKelDataService $service
   * @return BinaryFileResponse
   */
  public function export8KelData(Tabel8KelData $tabel, DelapanKelDataService $service): BinaryFileResponse
  {
    $uraians = $service->getAllUraianByTabelId($tabel);
    $tahuns = $service->getAllTahun($tabel);
    $fitur = $tabel->fitur8KelData->first();
    $crudRoutePart = 'delapankeldata';
    $fileName = $this->formatFileName($tabel->nama_menu, '8 Kelompok Data');

    return Excel::download(new IsiUraianExport($crudRoutePart, $fitur, $uraians, $tahuns), $fileName);
  }

  /**
   * Undocumented function
   *
   * @param TabelRpjmd $tabel
   * @param RpjmdService $service
   * @return BinaryFileResponse
   */
  public function exportRpjmd(TabelRpjmd $tabel, RpjmdService $service): BinaryFileResponse
  {
    $uraians = $service->getAllUraianByTabelId($tabel);
    $tahuns = $service->getAllTahun($tabel);
    $fitur = $tabel->fiturRpjmd->first();
    $crudRoutePart = 'rpjmd';
    $fileName = $this->formatFileName($tabel->nama_menu, 'RPJMD');

    return Excel::download(new IsiUraianExport($crudRoutePart, $fitur, $uraians, $tahuns), $fileName);
  }

  /**
   * Undocumented function
   *
   * @param TabelBps $tabel
   * @param BpsService $service
   * @return BinaryFileResponse
   */
  public function exportBps(TabelBps $tabel, BpsService $service): BinaryFileResponse
  {
    $uraians = $service->getAllUraianByTabelId($tabel);
    $tahuns = $service->getAllTahun($tabel);
    $fitur = $tabel->fiturBps->first();
    $crudRoutePart = 'bps';
    $fileName = $this->formatFileName($tabel->nama_menu, 'BPS');

    return Excel::download(new IsiUraianExport($crudRoutePart, $fitur, $uraians, $tahuns), $fileName);
  }

  /**
   * Undocumented function
   *
   * @param TabelIndikator $tabel
   * @param IndikatorService $service
   * @return BinaryFileResponse
   */
  public function exportIndikator(TabelIndikator $tabel, IndikatorService $service): BinaryFileResponse
  {
    $uraians = $service->getAllUraianByTabelId($tabel);
    $tahuns = $service->getAllTahun($tabel);
    $fitur = $tabel->fiturIndikator->first();
    $crudRoutePart = 'indikator';
    $fileName = $this->formatFileName($tabel->nama_menu, 'Indikator');

    return Excel::download(new IsiUraianExport($crudRoutePart, $fitur, $uraians, $tahuns), $fileName);
  }
}
