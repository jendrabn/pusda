<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skpd;
use App\Models\KategoriSkpd;
use App\Models\TabelRpjmd;
use App\Services\RpjmdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class RpjmdController extends Controller
{
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

    return view('admin.isiUraian.index', compact('categories', 'skpd', 'tabelIds'));
  }

  public function category(KategoriSkpd $category)
  {
    return view('admin.isiUraian.category', compact('category'));
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

    $fitur = $tabel->fiturRpjmd()->firstOrcreate([]);
    $files = $tabel->fileRpjmd;

    return view('admin.isiuraian.input', compact('categories', 'skpd', 'tabel', 'uraians',  'fitur', 'files', 'tahuns', 'skpds', 'tabelIds'));
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
            $isi  = $uraian->isiRpjmd->where('tahun', $request->tahun)->first();

            if (is_null($isi)) {
              $uraian->isiRpjmd()->create([
                'tahun' => $request->tahun,
                'isi' => 0
              ]);
            }
          }
        });

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();

      return back()->with('error-message', $e->getMessage());
    }

    return back()->with('success-message', 'Saved.');
  }

  public function destroyTahun(TabelRpjmd $tabel, int $tahun)
  {
    DB::beginTransaction();

    try {
      $tabel->uraianRpjmd->each(fn ($uraian) => $uraian->isiRpjmd()->where('tahun', $tahun)->delete());

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();

      return back()->with('error-message', $e->getMessage());
    }

    return back()->with('success-message', 'Deleted.');
  }
}
