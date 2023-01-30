<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Skpd;
use App\Models\Tabel8KelData;
use App\Models\Uraian8KelData;
use Illuminate\Support\Facades\View;

class SkpdController extends Controller
{

  public function __construct()
  {
    View::share([
      'title' => '8 Kelompok Data SKPD'
    ]);
  }

  public function index()
  {
    $skpds = Skpd::where('id', '!=', 1)->orderBy('kategori_skpd_id', 'asc')->get();

    return view('front.skpd', compact('skpds'));
  }

  public function menu(Skpd $skpd)
  {
    $tabel8KelDataIds = Uraian8KelData::select('tabel_8keldata_id as id')
      ->where('skpd_id', $skpd->id)
      ->groupBy('tabel_8keldata_id')
      ->get();

    $categories = Tabel8KelData::where('parent_id', 1)->get();

    return view('front.skpd-delapankeldata', compact('tabel8KelDataIds', 'categories'));
  }
}
