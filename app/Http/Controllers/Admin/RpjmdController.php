<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileRpjmd;
use App\Models\FiturRpjmd;
use App\Models\Skpd;
use App\Models\KategoriSkpd;
use App\Models\TabelRpjmd;
use App\Models\UraianRpjmd;
use App\Services\RpjmdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

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

  public function edit(Request $request, UraianRpjmd $uraian)
  {
    $isi = $this->service->getAllIsiByUraianId($uraian);
    $tahuns = $isi->map(fn ($item) => $item->tahun);
    $tabelId = $uraian->tabel_rpjmd_id;

    return view('admin.isiUraian.edit', compact('uraian', 'isi', 'tahuns', 'tabelId'));
  }

  public function update(Request $request, UraianRpjmd $uraian)
  {
    $isi = $this->service->getAllIsiByUraianId($uraian);
    $tahuns = $isi->map(fn ($item) => $item->tahun);

    $rules = [
      'uraian' => ['required', 'string'],
      'satuan' => ['required', 'string'],
      'ketersediaan_data' => ['required', 'boolean'],
    ];

    foreach ($tahuns as $tahun) {
      $rules['tahun_' . $tahun] = ['required', 'integer'];
    }

    $this->validate($request, $rules);

    DB::beginTransaction();

    try {
      $uraian->update($request->all());

      $isi->each(function ($item) use ($request) {
        $item->isi = $request->get('tahun_' . $item->tahun);
        $item->save();
      });

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();

      return back()->with('error-message', $e->getMessage());
    }

    return back()->with('success-message', 'Updated.');
  }

  public function destroy(UraianRpjmd $uraian)
  {
    $uraian->delete();

    return back()->with('success-message', 'Deleted.');
  }

  public function updateFitur(Request $request, FiturRpjmd $fitur)
  {
    $request->validate([
      'deskripsi' => ['nullable', 'string', 'max:255'],
      'analisis'  => ['nullable', 'string', 'max:255'],
      'permasalahan'  => ['nullable', 'string', 'max:255'],
      'solusi'  => ['nullable', 'string', 'max:255'],
      'saran'  => ['nullable', 'string', 'max:255']
    ]);

    $fitur->update($request->all());

    return back()->with('success-message', 'Updated');
  }

  public function storeFile(Request $request, TabelRpjmd $tabel)
  {
    $request->validate([
      'document' => ['required', 'max:10240'],
    ]);

    $file = $request->file('document');

    $tabel->fileRpjmd()->create([
      'nama' => $file->getClientOriginalName(),
      'path' => $file->storePublicly('file_pendukung', 'public')
    ]);

    return back()->with('success-message', 'Saved.');
  }

  public function destroyFile(FileRpjmd $file)
  {
    Storage::disk('public')->delete($file->path);

    $file->delete();

    return back()->with('success-message', 'Deleted.');
  }

  public function downloadFile(FileRpjmd $file)
  {
    return Storage::disk('public')->download($file->path, $file->nama);
  }

  public function updateSumberData(Request $request, UraianRpjmd $uraian)
  {
    $request->validate(['skpd_id' => ['required', 'integer', 'exists:skpd,id']]);

    $uraian->skpd_id = $request->skpd_id;
    $uraian->save();

    return response()->json([], Response::HTTP_NO_CONTENT);
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

  public function chart(UraianRpjmd $uraian)
  {
    return response()->json($this->service->getChartData($uraian), Response::HTTP_OK);
  }
}
