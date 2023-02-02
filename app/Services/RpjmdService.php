<?php

namespace App\Services;

use App\Models\IsiRpjmd;
use App\Models\TabelRpjmd;
use App\Models\UraianRpjmd;

class RpjmdService
{

  public function getCategories()
  {
    return TabelRpjmd::with('childs.childs.childs')->get();
  }

  public function getAllTahun(TabelRpjmd $tabel)
  {
    return IsiRpjmd::whereNotNull('tahun')
      ->whereHas('uraianRpjmd', fn ($q) => $q->where('tabel_rpjmd_id', $tabel->id))
      ->groupBy('tahun')
      ->orderBy('tahun', 'asc')
      ->get()
      ->map(fn ($item) => $item->tahun);
  }

  public function getChartData(UraianRpjmd $uraian)
  {
    return  [
      'uraian' => $uraian->uraian,
      'isi' => $uraian->isiRpjmd()->whereNotNull('tahun')->groupBy('tahun')->orderBy('tahun', 'asc')->get()
    ];
  }

  public function getAllIsiByUraianId(UraianRpjmd $uraian)
  {
    return  $uraian->isiRpjmd()->whereNotNull('tahun')->orderBy('tahun', 'asc')->get();
  }

  public function getAllUraianByTabelId(TabelRpjmd $tabel)
  {
    return  $tabel->uraianRpjmd()->with('childs.isiRpjmd')->whereNull('parent_id')->get();
  }
}
