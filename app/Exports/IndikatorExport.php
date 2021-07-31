<?php

namespace App\Exports;

use App\Models\FileIndikator;
use App\Models\FiturIndikator;
use App\Models\IsiIndikator;
use App\Models\UraianIndikator;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class IndikatorExport implements FromView, ShouldAutoSize
{

    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $uraianIndikator = UraianIndikator::getUraianByTableId($this->id);
        $fiturIndikator = FiturIndikator::getFiturByTableId($this->id);
        $files = FileIndikator::where('tabel_indikator_id',  $this->id)->get();
        $years = IsiIndikator::getYears($this->id);

        return view('exports.indikator', compact('uraianIndikator', 'fiturIndikator', 'files', 'years'));
    }
}
