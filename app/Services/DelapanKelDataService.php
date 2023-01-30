<?php

namespace App\Services;

use App\Models\Isi8KelData;
use App\Models\Tabel8KelData;
use App\Models\Uraian8KelData;

class DelapanKelDataService
{

  public function getCategories()
  {
    return Tabel8KelData::with('childs.childs.childs')->get();
  }

  public function getAllTahun(Tabel8KelData $tabel)
  {
    return  Isi8KelData::whereNotNull('tahun')
      ->whereHas('uraian8KelData', fn ($q) => $q->where('tabel_8keldata_id', $tabel->id))
      ->groupBy('tahun')
      ->orderBy('tahun', 'asc')
      ->get()
      ->map(fn ($item) => $item->tahun);
  }

  public function getChartData(Uraian8KelData $uraian)
  {
    return   [
      'uraian' => $uraian->uraian,
      'isi' => $uraian->isi8KelData()->whereNotNull('tahun')->groupBy('tahun')->orderBy('tahun', 'asc')->get()
    ];
  }

  public function getIsiByUraianId(Uraian8KelData $uraian)
  {
    return $uraian->isi8KelData()->whereNotNull('tahun')->orderBy('tahun', 'asc')->get();
  }
}
