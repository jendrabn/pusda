<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\TabelIndikator;
use App\Models\UraianIndikator;
use App\Services\IndikatorService;
use App\Services\SeoService;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class IndikatorController extends Controller
{

  private IndikatorService $service;
  private SeoService $seo;

  public function __construct(IndikatorService $service, SeoService $seo)
  {
    $this->service = $service;
    $this->seo = $seo;

    View::share([
      'routePart' => 'indikator',
      'title' => 'Indikator'
    ]);
  }

  public function index()
  {
    $this->seo->setPage('Indikator Kinerja', 'Indikator dan tabel kinerja Kabupaten Situbondo.', [
      'canonical' => route('indikator.index'),
    ]);

    $categories = TabelIndikator::with('childs.childs.childs')->where('parent_id', 1)->get();

    return view('front.index', compact('categories'));
  }
  public function tabel(TabelIndikator $tabel)
  {
    $this->seo->setPage('Indikator ' . $tabel->nama_menu, 'Tabel indikator: ' . $tabel->nama_menu . '.', [
      'canonical' => route('indikator.tabel', $tabel),
      'schema_type' => 'Article',
      'og_type' => 'article',
    ]);

    $uraians = $tabel->uraianIndikator()->with('childs.isiIndikator')->whereNull('parent_id')->get();
    $fitur = $tabel->fiturIndikator;
    $tahuns = $this->service->getAllTahun($tabel);

    return view('front.tabel', compact('tabel', 'uraians',  'fitur',  'tahuns'));
  }

  public function chart(UraianIndikator $uraian)
  {
    return response()->json($this->service->getChartData($uraian), Response::HTTP_OK);
  }
}
