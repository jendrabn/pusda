<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\TabelBps;
use App\Models\UraianBps;
use App\Services\BpsService;
use App\Services\SeoService;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class BpsController extends Controller
{
  private BpsService $service;
  private SeoService $seo;

  public function __construct(BpsService $service, SeoService $seo)
  {
    $this->service = $service;
    $this->seo = $seo;

    View::share([
      'routePart' => 'bps',
      'title' => 'BPS'
    ]);
  }

  public function index()
  {
    $this->seo->setPage('BPS', 'Statistik dan data BPS Kabupaten Situbondo.', [
      'canonical' => route('bps.index'),
    ]);

    $categories = TabelBps::with('childs.childs.childs')->where('parent_id', 1)->get();

    return view('front.index', compact('categories'));
  }

  public function tabel(TabelBps $tabel)
  {
    $this->seo->setPage('BPS ' . $tabel->nama_menu, 'Tabel BPS: ' . $tabel->nama_menu . '.', [
      'canonical' => route('bps.tabel', $tabel),
      'schema_type' => 'Article',
      'og_type' => 'article',
    ]);

    $uraians = $tabel->uraianBps()->with('childs.isiBps')->whereNull('parent_id')->get();
    $fitur = $tabel->fiturBps;
    $tahuns =  $this->service->getAllTahun($tabel);

    return view('front.tabel', compact('tabel', 'uraians',  'fitur',  'tahuns'));
  }

  public function chart(UraianBps $uraian)
  {
    return response()->json($this->service->getChartData($uraian), Response::HTTP_OK);
  }
}
