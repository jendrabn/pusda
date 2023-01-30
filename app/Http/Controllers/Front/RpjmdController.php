<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\TabelRpjmd;
use App\Models\UraianRpjmd;
use App\Services\RpjmdService;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class RpjmdController extends Controller
{

  private RpjmdService $service;

  public function __construct(RpjmdService $service)
  {
    $this->service = $service;

    View::share([
      'routePart' => 'rpjmd',
      'title' => 'RPJMD'
    ]);
  }

  public function index()
  {
    $categories = TabelRpjmd::with('childs.childs.childs')->where('parent_id', 1)->get();

    return view('front.index', compact('categories'));
  }
  public function tabel(TabelRpjmd $tabel)
  {
    $uraians = $tabel->uraianRpjmd()->with('childs.isiRpjmd')->whereNull('parent_id')->get();
    $fitur = $tabel->fiturRpjmd()->firstOrcreate([]);
    $tahuns = $this->service->getAllTahun($tabel);

    return view('front.tabel', compact('tabel', 'uraians',  'fitur',  'tahuns'));
  }

  public function chart(UraianRpjmd $uraian)
  {
    return response()->json($this->service->getChartData($uraian), Response::HTTP_OK);
  }
}
