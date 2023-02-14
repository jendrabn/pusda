<?php

namespace App\Http\Controllers\Skpd;

use App\Http\Controllers\Controller;
use App\Http\Traits\RpjmdTrait;
use App\Models\Skpd;
use App\Models\TabelRpjmd;
use App\Services\RpjmdService;
use Illuminate\Support\Facades\View;

class RpjmdController extends Controller
{
  use RpjmdTrait;

  private RpjmdService $rpjmdService;

  public function __construct(RpjmdService $rpjmdService)
  {
    $this->rpjmdService = $rpjmdService;

    View::share([
      'crudRoutePart' => 'rpjmd',
      'title' => 'RPJMD'
    ]);
  }

  public function index()
  {
    $skpd = auth()->user()->skpd;
    $categories = $this->rpjmdService->getCategories();
    $tabelIds = $skpd->uraianRpjmd()
      ->select('tabel_rpjmd_id as tabel_id')
      ->groupBy('tabel_id')
      ->get();

    return view('skpd.isi-uraian.index', compact('skpd', 'tabelIds', 'categories'));
  }

  public function input(TabelRpjmd $tabel)
  {
    $skpd = auth()->user()->skpd;
    $skpds = Skpd::pluck('singkatan', 'id');
    $tabelIds = $skpd->uraianRpjmd()
      ->select('tabel_rpjmd_id as tabel_id')
      ->groupBy('tabel_id')
      ->get();
    $categories = $this->rpjmdService->getCategories();
    $uraians = $this->rpjmdService->getAllUraianByTabelId($tabel);
    $fitur = $tabel->fiturRpjmd;
    $files = $tabel->fileRpjmd;
    $tahuns = $this->rpjmdService->getAllTahun($tabel);

    return view('admin.isiUraian.input', compact('tabel', 'skpd', 'skpds',  'categories', 'uraians',  'fitur', 'files', 'tahuns'));
  }
}
