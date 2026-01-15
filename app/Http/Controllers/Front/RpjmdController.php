<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\TabelRpjmd;
use App\Models\UraianRpjmd;
use App\Services\RpjmdService;
use App\Services\SeoService;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class RpjmdController extends Controller
{

  private RpjmdService $service;
  private SeoService $seo;

  public function __construct(RpjmdService $service, SeoService $seo)
  {
    $this->service = $service;
    $this->seo = $seo;

    View::share([
      'routePart' => 'rpjmd',
      'title' => 'RPJMD'
    ]);
  }

  public function index()
  {
    $this->seo->setPage('RPJMD', 'Dokumen dan tabel RPJMD Kabupaten Situbondo.', [
      'canonical' => route('rpjmd.index'),
    ]);

    $categories = TabelRpjmd::with('childs.childs.childs')->where('parent_id', 1)->get();

    return view('front.index', compact('categories'));
  }
  public function tabel(TabelRpjmd $tabel)
  {
    $this->seo->setPage('RPJMD ' . $tabel->nama_menu, 'Tabel RPJMD: ' . $tabel->nama_menu . '.', [
      'canonical' => route('rpjmd.tabel', $tabel),
      'schema_type' => 'Article',
      'og_type' => 'article',
    ]);

    $uraians = $tabel->uraianRpjmd()->with('childs.isiRpjmd')->whereNull('parent_id')->get();
    $fitur = $tabel->fiturRpjmd;
    $tahuns = $this->service->getAllTahun($tabel);

    return view('front.tabel', compact('tabel', 'uraians',  'fitur',  'tahuns'));
  }

  public function chart(UraianRpjmd $uraian)
  {
    return response()->json($this->service->getChartData($uraian), Response::HTTP_OK);
  }
}
