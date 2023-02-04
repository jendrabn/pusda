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

  private RpjmdService $service;

  public function __construct(RpjmdService $service)
  {
    $this->service = $service;

    View::share([
      'crudRoutePart' => 'rpjmd',
      'title' => 'RPJMD'
    ]);
  }

  public function index()
  {
    $skpd = auth()->user()->skpd;
    $categories = $this->service->getCategories();
    $tabelIds = $skpd->uraianRpjmd()
      ->select('tabel_rpjmd_id as tabel_id')
      ->groupBy('tabel_id')
      ->get();

    return view('admin.isiUraian.index', compact('skpd', 'tabelIds', 'categories'));
  }

  public function input(TabelRpjmd $tabel)
  {
    $skpd = auth()->user()->skpd;
    $skpds = Skpd::pluck('singkatan', 'id');
    $tabelIds = $skpd->uraianRpjmd()
      ->select('tabel_rpjmd_id as tabel_id')
      ->groupBy('tabel_id')
      ->get();
    $categories = $this->service->getCategories();
    $uraians = $this->service->getAllUraianByTabelId($tabel);
    $fitur = $tabel->fiturRpjmd()->firstOrCreate([]);
    $files = $tabel->fileRpjmd;
    $tahuns = $this->service->getAllTahun($tabel);

    return view('admin.isiUraian.input', compact('tabel', 'skpd', 'skpds',  'categories', 'uraians',  'fitur', 'files', 'tahuns'));
  }
}
