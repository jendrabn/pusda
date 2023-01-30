<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\TabelIndikator;
use App\Models\UraianIndikator;
use App\Services\IndikatorService;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class IndikatorController extends Controller
{

  private IndikatorService $service;

  public function __construct(IndikatorService $service)
  {
    $this->service = $service;

    View::share([
      'routePart' => 'indikator',
      'title' => 'Indikator'
    ]);
  }

  public function index()
  {
    $categories = TabelIndikator::with('childs.childs.childs')->where('parent_id', 1)->get();

    return view('front.index', compact('categories'));
  }
  public function tabel(TabelIndikator $tabel)
  {
    $uraians = $tabel->uraianIndikator()->with('childs.isiIndikator')->whereNull('parent_id')->get();
    $fitur = $tabel->fiturIndikator()->firstOrCreate([]);
    $tahuns = $this->service->getAllTahun($tabel);

    return view('front.tabel', compact('tabel', 'uraians',  'fitur',  'tahuns'));
  }

  public function chart(UraianIndikator $uraian)
  {
    return response()->json($this->service->getChartData($uraian), Response::HTTP_OK);
  }
}
