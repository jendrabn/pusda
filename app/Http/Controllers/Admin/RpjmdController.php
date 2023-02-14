<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\RpjmdTrait;
use App\Models\Skpd;
use App\Models\KategoriSkpd;
use App\Models\TabelRpjmd;
use App\Services\RpjmdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class RpjmdController extends Controller
{

  use RpjmdTrait;

  private RpjmdService $service;

  public function __construct(RpjmdService $service)
  {
    $this->service = $service;

    View::share([
      'crudRoutePart' => 'rpjmd',
      'title' => 'RPJMD'
    ]);
  }

  public function index(Request $request)
  {
    $skpd = Skpd::find($request->skpd);
    $categories = $this->service->getCategories();
    $tabelIds = $skpd?->uraianRpjmd()
      ->select('tabel_rpjmd_id as tabel_id')
      ->where('skpd_id', $request->skpd)
      ->groupBy('tabel_id')
      ->get();

    return view('admin.isi-uraian.index', compact('categories', 'skpd', 'tabelIds'));
  }

  public function category(KategoriSkpd $category)
  {
    return view('admin.isi-uraian.category', compact('category'));
  }

  public function input(Request $request,  TabelRpjmd $tabel)
  {
    $tahuns = $this->service->getAllTahun($tabel);
    $uraians = $this->service->getAllUraianByTabelId($tabel);
    $skpd = Skpd::find($request->skpd);
    $skpds = Skpd::pluck('singkatan', 'id');
    $categories = $this->service->getCategories();

    $tabelIds = $skpd?->uraianRpjmd()
      ->select('tabel_rpjmd_id as tabel_id')
      ->where('skpd_id', $request->skpd)
      ->groupBy('tabel_id')
      ->get();

    $fitur = $tabel->fiturRpjmd;
    $files = $tabel->fileRpjmd;

    return view('admin.isi-uraian.input', compact('categories', 'skpd', 'tabel', 'uraians',  'fitur', 'files', 'tahuns', 'skpds', 'tabelIds'));
  }

  public function storeTahun(Request $request, TabelRpjmd $tabel)
  {
    $request->validate([
      'tahun' => ['required', 'integer', 'min:2010', 'max:2030'],
    ]);

    DB::beginTransaction();
    try {
      $tabel->uraianRpjmd()->with('isiRpjmd')->get()
        ->each(function ($uraian) use ($request) {
          if ($uraian->parent_id) {
            $uraian->isiRpjmd()->where('tahun', $request->tahun)->firstOrCreate([
              'tahun' => $request->tahun,
              'isi' => 0
            ]);
          }
        });

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();

      throw new \Exception($e->getMessage());
    }

    return back()->with('success-message', 'Successfully Saved.');
  }

  public function destroyTahun(TabelRpjmd $tabel, int $tahun)
  {
    DB::beginTransaction();
    try {
      $tabel->uraianRpjmd->each(fn ($uraian) => $uraian->isiRpjmd()->where('tahun', $tahun)->delete());

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();

      throw new \Exception($e->getMessage());
    }

    return back()->with('success-message', 'Successfully Deleted.');
  }
}
