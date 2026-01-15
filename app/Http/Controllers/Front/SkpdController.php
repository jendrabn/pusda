<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Skpd;
use App\Models\Tabel8KelData;
use App\Models\Uraian8KelData;
use App\Services\SeoService;
use Illuminate\Support\Facades\View;

class SkpdController extends Controller
{
  private SeoService $seo;

  public function __construct(SeoService $seo)
  {
    $this->seo = $seo;

    View::share([
      'title' => '8 Kelompok Data SKPD'
    ]);
  }

  public function index()
  {
    $this->seo->setPage('SKPD', 'Daftar SKPD dan akses data 8 kelompok di Kabupaten Situbondo.', [
      'canonical' => route('skpd'),
    ]);

    $skpds = Skpd::where('id', '!=', 1)->orderBy('kategori_skpd_id', 'asc')->get();

    return view('front.skpd', compact('skpds'));
  }

  public function menu(Skpd $skpd)
  {
    $this->seo->setPage('SKPD ' . $skpd->nama, 'Data 8 kelompok untuk ' . $skpd->nama . '.', [
      'canonical' => route('delapankeldata.skpd', $skpd),
    ]);

    $tabel8KelDataIds = Uraian8KelData::select('tabel_8keldata_id as id')
      ->where('skpd_id', $skpd->id)
      ->groupBy('tabel_8keldata_id')
      ->get();

    $categories = Tabel8KelData::where('parent_id', 1)->get();

    return view('front.skpd-delapankeldata', compact('tabel8KelDataIds', 'categories'));
  }
}
