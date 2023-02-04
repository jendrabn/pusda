<?php

namespace App\Http\Controllers\Skpd;

use App\Http\Controllers\Controller;
use App\Http\Traits\DelapanKelDataTrait;
use App\Models\File8KelData;
use App\Models\Fitur8KelData;
use App\Models\Skpd;
use App\Models\Tabel8KelData;
use App\Models\Uraian8KelData;
use App\Services\DelapanKelDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class DelapanKelDataController extends Controller
{

  use DelapanKelDataTrait;

  private DelapanKelDataService $service;

  public function __construct(DelapanKelDataService $service)
  {
    $this->service = $service;

    View::share([
      'crudRoutePart' => 'delapankeldata',
      'title' => '8 Kelompok Data'
    ]);
  }

  public function index()
  {
    $skpd = auth()->user()->skpd;
    $categories = $this->service->getCategories();
    $tabelIds = $skpd->uraian8KelData()
      ->select('tabel_8keldata_id as tabel_id')
      ->groupBy('tabel_id')
      ->get();

    return view('admin.isiUraian.index', compact('skpd', 'tabelIds', 'categories'));
  }

  public function input(Tabel8KelData $tabel)
  {
    $skpd = auth()->user()->skpd;
    $skpds = Skpd::pluck('singkatan', 'id');
    $categories = $this->service->getCategories();
    $tabelIds = $skpd->uraian8KelData()
      ->select('tabel_8keldata_id as tabel_id')
      ->groupBy('tabel_id')
      ->get();

    $uraians = $this->service->getAllUraianByTabelId($tabel);
    $tahuns = $this->service->getAllTahun($tabel);
    $fitur = $tabel->fitur8KelData()->firstOrCreate([]);
    $files = $tabel->file8KelData;

    return view('admin.isiUraian.input', compact('tabel', 'skpd', 'skpds',  'categories', 'uraians',  'fitur', 'files', 'tahuns'));
  }
}
