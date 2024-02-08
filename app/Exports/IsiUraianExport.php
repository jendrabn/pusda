<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IsiUraianExport implements FromView
{
  private string $crudRoutePart;

  private $fitur;

  private $uraians;

  private $tahuns;

  public function __construct($crudRoutePart, $fitur, $uraians, $tahuns)
  {
    $this->crudRoutePart = $crudRoutePart;
    $this->fitur = $fitur;
    $this->uraians = $uraians;
    $this->tahuns = $tahuns;
  }

  public function view(): View
  {
    return view('isi_uraian_export', [
      'crudRoutePart' => $this->crudRoutePart,
      'fitur' => $this->fitur,
      'uraians' => $this->uraians,
      'tahuns' => $this->tahuns
    ]);
  }
}
