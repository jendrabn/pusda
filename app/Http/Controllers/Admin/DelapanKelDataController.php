<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\DelapanKelDataTrait;
use App\Models\Skpd;
use App\Models\KategoriSkpd;
use App\Models\Tabel8KelData;
use App\Services\DelapanKelDataService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

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

  public function index(Request $request)
  {
    $skpd = Skpd::find($request->skpd);
    $categories = $this->service->getCategories();
    $tabelIds = $skpd?->uraian8KelData()
      ->select('tabel_8keldata_id as tabel_id')
      ->where('skpd_id', $request->skpd)
      ->groupBy('tabel_id')
      ->get();

    return view('admin.isiUraian.index', compact('categories', 'skpd', 'tabelIds'));
  }

  public function category(KategoriSkpd $category)
  {
    return view('admin.isiUraian.category', compact('category'));
  }

  public function input(Request $request,  Tabel8KelData $tabel)
  {
    $tahuns = $this->service->getAllTahun($tabel);
    $uraians = $this->service->getAllUraianByTabelId($tabel);
    $skpd = Skpd::find($request->skpd);
    $skpds = Skpd::pluck('singkatan', 'id');
    $categories = $this->service->getCategories();
    $tabelIds = $skpd?->uraian8KelData()
      ->select('tabel_8keldata_id as tabel_id')
      ->where('skpd_id', $request->skpd)
      ->groupBy('tabel_id')
      ->get();
    $fitur = $tabel->fitur8KelData()->firstOrCreate([]);
    $files = $tabel->file8KelData;

    return view('admin.isiUraian.input', compact('categories', 'skpd', 'tabel', 'uraians',  'fitur', 'files', 'tahuns', 'skpds', 'tabelIds'));
  }


  public function storeTahun(Request $request, Tabel8KelData $tabel)
  {
    $request->validate([
      'tahun' => ['required', 'integer', 'min:2010', 'max:2030'],
    ]);

    DB::beginTransaction();

    try {
      $tabel->uraian8KelData()->with('isi8KelData')->get()
        ->each(function ($uraian) use ($request) {
          if ($uraian->parent_id) {
            $isi  = $uraian->isi8KelData->where('tahun', $request->tahun)->first();

            if (is_null($isi)) {
              $uraian->isi8KelData()->create([
                'tahun' => $request->tahun,
                'isi' => 0
              ]);
            }
          }
        });

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      throw new Exception($e->getMessage());
    }

    return back()->with('success-message', 'Saved.');
  }

  public function destroyTahun(Tabel8KelData $tabel, int $tahun)
  {
    DB::beginTransaction();

    try {
      $tabel->uraian8KelData->each(fn ($uraian) => $uraian->isi8KelData()->where('tahun', $tahun)->delete());

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();

      throw new Exception($e->getMessage());
    }

    return back()->with('success-message', 'Deleted.');
  }
}
