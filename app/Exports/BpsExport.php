<?php

namespace App\Exports;

use App\Models\FileBps;
use App\Models\FiturBps;
use App\Models\IsiBps;
use App\Models\UraianBps;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BpsExport implements FromView, ShouldAutoSize
{

    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $uraianBps = UraianBps::getUraianByTableId($this->id);
        $fiturBps = FiturBps::getFiturByTableId($this->id);
        $files = FileBps::where('tabel_bps_id',  $this->id)->get();
        $years = IsiBps::getYears();

        return view('exports.bps', compact('uraianBps', 'fiturBps', 'files', 'years'));
    }
}
