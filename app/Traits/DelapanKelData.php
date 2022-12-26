<?php

namespace App\Traits;

use App\Models\Isi8KelData;
use App\Models\Uraian8KelData;

trait DelapanKelData
{
    private function tahunList($tabelId)
    {
        return
            Isi8KelData::select('tahun')
            ->whereHas('uraian8KelData', function ($q) use ($tabelId) {
                $q->where('tabel_8keldata_id', '=', $tabelId);
            })
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get()
            ->map(fn ($tahun) => $tahun->tahun);
    }


    public function getUraian($tabelId)
    {
        $uraian = Uraian8KelData::with('isi8KelData')->where('tabel_8keldata_id', $tabelId)->get();
        $tahuns = $this->tahunList($tabelId);

        $uraian->each(function ($uraian) use ($tahuns) {
            if ($uraian->parent_id) {
                foreach ($tahuns as $tahun) {
                    $isi = $uraian->isi8KelData->where('tahun', $tahun)->first();
                    if (is_null($isi)) {
                        Isi8KelData::create([
                            'uraian_8keldata_id' => $uraian->id,
                            'tahun' => $tahun,
                            'isi' => 0
                        ]);
                    }
                }
            }
        });

        return Uraian8KelData::with('childs.isi8KelData')->where('tabel_8keldata_id', $tabelId)->whereNull('parent_id')->get();
    }
}
