<?php

namespace App\Exports;

use App\Models\FileRpjmd;
use App\Models\FiturRpjmd;
use App\Models\IsiRpjmd;
use App\Models\UraianRpjmd;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RpjmdExport implements FromView
{

    private $id;


    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $uraianRpjmd = UraianRpjmd::getUraianByTableId($this->id);
        $fiturRpjmd = FiturRpjmd::getFiturByTableId($this->id);
        $files = FileRpjmd::where('tabel_rpjmd_id',  $this->id)->get();
        $years = IsiRpjmd::getYears();;

        return view('exports.rpjmd', compact('uraianRpjmd', 'fiturRpjmd', 'files', 'years'));
    }
}
