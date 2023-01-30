<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\TabelBps;
use App\Models\UraianBps;
use App\Services\BpsService;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class BpsController extends Controller
{
  private BpsService $service;

  public function __construct(BpsService $service)
  {
    $this->service = $service;

    View::share([
      'routePart' => 'bps',
      'title' => 'BPS'
    ]);
  }

  public function index()
  {
    $categories = TabelBps::with('childs.childs.childs')->where('parent_id', 1)->get();

    return view('front.index', compact('categories'));
  }

  public function tabel(TabelBps $tabel)
  {
    $uraians = $tabel->uraianBps()->with('childs.isiBps')->whereNull('parent_id')->get();
    $fitur = $tabel->fiturBps()->firstOrCreate([]);
    $tahuns =  $this->service->getAllTahun($tabel);

    return view('front.tabel', compact('tabel', 'uraians',  'fitur',  'tahuns'));
  }

  public function chart(UraianBps $uraian)
  {
    return response()->json($this->service->getChartData($uraian), Response::HTTP_OK);
  }
}
