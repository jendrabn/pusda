<?php

namespace App\Services;

use App\Models\IsiBps;
use App\Models\TabelBps;
use App\Models\UraianBps;

class BpsService
{

  public function getCategories()
  {
    return TabelBps::with('childs.childs.childs')->get();
  }

  public function getAllTahun(TabelBps $tabel)
  {
    return IsiBps::whereNotNull('tahun')
      ->whereHas('uraianBps', fn ($q) => $q->where('tabel_Bps_id', $tabel->id))
      ->groupBy('tahun')
      ->orderBy('tahun', 'asc')
      ->get()
      ->map(fn ($item) => $item->tahun);
  }

  public function getChartData(UraianBps $uraian)
  {
    return [
      'uraian' => $uraian->uraian,
      'isi' => $uraian->isiBps()->whereNotNull('tahun')->groupBy('tahun')->orderBy('tahun', 'asc')->get()
    ];
  }

  public function getIsiByUraianId(UraianBps $uraian)
  {
    return  $uraian->isiBps()->whereNotNull('tahun')->orderBy('tahun', 'asc')->get();
  }

  public function getAllUraianByTabelId(TabelBps $tabel)
  {
    return $tabel->uraianBps()->with('childs.isiBps')->whereNull('parent_id')->get();
  }
}
