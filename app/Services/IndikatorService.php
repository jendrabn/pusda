<?php

namespace App\Services {

  use App\Models\IsiIndikator;
  use App\Models\TabelIndikator;
  use App\Models\UraianIndikator;

  class IndikatorService
  {

    public function getCategories()
    {
      return TabelIndikator::with('childs.childs.childs')->get();
    }

    public function getAllTahun(TabelIndikator $tabel)
    {
      return IsiIndikator::whereNotNull('tahun')
        ->whereHas('uraianIndikator', fn ($q) => $q->where('tabel_indikator_id', $tabel->id))
        ->groupBy('tahun')
        ->orderBy('tahun', 'asc')
        ->get()
        ->map(fn ($item) => $item->tahun);
    }

    public function getChartData(UraianIndikator $uraian)
    {
      return [
        'uraian' => $uraian->uraian,
        'isi' => $uraian->isiIndikator()->whereNotNull('tahun')->groupBy('tahun')->orderBy('tahun', 'asc')->get()
      ];
    }

    public function getIsiByUraianId(UraianIndikator $uraian)
    {
      return $uraian->isiIndikator()->whereNotNull('tahun')->orderBy('tahun', 'asc')->get();
    }

    public function getAllUraianByTabelId(TabelIndikator $tabel)
    {
      return $tabel->uraianIndikator()->with('childs.isiIndikator')->whereNull('parent_id')->get();
    }
  }
}
