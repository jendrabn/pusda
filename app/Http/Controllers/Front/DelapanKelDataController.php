<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Fitur8KelData;
use App\Models\Isi8KelData;
use App\Models\Tabel8KelData;
use App\Models\Uraian8KelData;
use App\Services\DelapanKelDataService;
use App\Services\SeoService;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class DelapanKelDataController extends Controller
{

  private DelapanKelDataService $service;
  private SeoService $seo;

  public function __construct(DelapanKelDataService $service, SeoService $seo)
  {
    $this->service = $service;
    $this->seo = $seo;

    View::share([
      'routePart' => 'delapankeldata',
      'title' => '8 Kelompok Data'
    ]);
  }

  public function index()
  {
    $this->seo->setPage('8 Kelompok Data', 'Kumpulan 8 kelompok data Kabupaten Situbondo.', [
      'canonical' => route('delapankeldata.index'),
    ]);

    $categories = Tabel8KelData::with('childs.childs.childs')->where('parent_id', 1)->get();

    return view('front.index', compact('categories'));
  }

  public function tabel(Tabel8KelData $tabel)
  {
    $this->seo->setPage('8 Kelompok Data ' . $tabel->nama_menu, 'Tabel 8 kelompok data: ' . $tabel->nama_menu . '.', [
      'canonical' => route('delapankeldata.tabel', $tabel),
      'schema_type' => 'Article',
      'og_type' => 'article',
    ]);

    $uraians = $this->service->getAllUraianByTabelId($tabel);
    $fitur = $tabel->fitur8KelData;
    $tahuns = $this->service->getAllTahun($tabel);

    return view('front.tabel', compact('tabel',  'uraians',  'fitur',  'tahuns'));
  }

  public function chart(Uraian8KelData $uraian)
  {
    return response()->json($this->service->getChartData($uraian), Response::HTTP_OK);
  }
}
