<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Fitur8KelData;
use App\Models\Isi8KelData;
use App\Models\Tabel8KelData;
use App\Models\Uraian8KelData;
use App\Services\DelapanKelDataService;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class DelapanKelDataController extends Controller
{

  private DelapanKelDataService $service;

  public function __construct(DelapanKelDataService $service)
  {
    $this->service = $service;

    View::share([
      'routePart' => 'delapankeldata',
      'title' => '8 Kelompok Data'
    ]);
  }

  public function index()
  {
    $categories = Tabel8KelData::with('childs.childs.childs')->where('parent_id', 1)->get();

    return view('front.index', compact('categories'));
  }

  public function tabel(Tabel8KelData $tabel)
  {
    $uraians = $this->service->getAllUraianByTabelId($tabel);
    $fitur = $tabel->fitur8KelData()->firstOrCreate([]);
    $tahuns = $this->service->getAllTahun($tabel);

    return view('front.tabel', compact('tabel',  'uraians',  'fitur',  'tahuns'));
  }

  public function chart(Uraian8KelData $uraian)
  {
    return response()->json($this->service->getChartData($uraian), Response::HTTP_OK);
  }
}
