<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileBps;
use App\Models\FiturBps;
use App\Models\TabelBps;
use App\Models\UraianBps;
use App\Services\BpsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class BpsController extends Controller
{
  private BpsService $service;

  public function __construct(BpsService $service)
  {
    View::share([
      'crudRoutePart' => 'bps',
      'title' => 'BPS'
    ]);

    $this->service = $service;
  }

  public function index()
  {
    $categories = $this->service->getCategories();

    return view('admin.isiUraian.index', compact('categories'));
  }

  public function input(TabelBps $tabel)
  {
    $tahuns = $this->service->getAllTahun($tabel);
    $uraians = $tabel->uraianBps()->with('childs.isiBps')->whereNull('parent_id')->get();
    $categories = $this->service->getCategories();
    $fitur = $tabel->fiturBps()->firstOrCreate([]);
    $files = $tabel->fileBps;

    return view('admin.isiuraian.input', compact('categories',  'tabel', 'uraians',  'fitur', 'files', 'tahuns'));
  }

  public function edit(Request $request, UraianBps $uraian)
  {
    $isi = $this->service->getIsiByUraianId($uraian);
    $tahuns = $isi->map(fn ($item) => $item->tahun);
    $tabelId = $uraian->tabel_bps_id;

    return view('admin.isiUraian.edit', compact('uraian', 'isi', 'tahuns', 'tabelId'));
  }

  public function update(Request $request, UraianBps $uraian)
  {
    $isi = $this->service->getIsiByUraianId($uraian);
    $tahuns = $isi->map(fn ($item) => $item->tahun);

    $rules = [
      'uraian' => ['required', 'string'],
      'satuan' => ['required', 'string'],
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

  public function destroy(UraianBps $uraian)
  {
    $uraian->delete();

    return back()->with('success-message', 'Deleted.');
  }

  public function updateFitur(Request $request, FiturBps $fitur)
  {
    $request->validate([
      'deskripsi' => ['nullable', 'string', 'max:255'],
      'analisis'  => ['nullable', 'string', 'max:255'],
      'permasalahan'  => ['nullable', 'string', 'max:255'],
      'solusi'  => ['nullable', 'string', 'max:255'],
      'saran'  => ['nullable', 'string', 'max:255']
    ]);

    $fitur->update($request->all());

    return back()->with('success-message', 'Updated.');
  }


  public function storeFile(Request $request, TabelBps $tabel)
  {
    $request->validate([
      'document' => ['required', 'max:10240'],
    ]);

    $file = $request->file('document');

    $tabel->fileBps()->create([
      'nama' => $file->getClientOriginalName(),
      'path' => $file->storePublicly('file_pendukung', 'public')
    ]);

    return back()->with('success-message', 'Saved.');
  }

  public function destroyFile(FileBps $file)
  {
    Storage::disk('public')->delete($file->path);

    $file->delete();

    return back()->with('success-message', 'Deleted.');
  }

  public function downloadFile(FileBps $file)
  {
    return Storage::disk('public')->download($file->path, $file->nama);
  }

  public function storeTahun(Request $request, TabelBps $tabel)
  {
    $request->validate([
      'tahun' => ['required', 'integer', 'min:2010', 'max:2030'],
    ]);

    DB::beginTransaction();

    try {
      $tabel->uraianBps()->with('isiBps')->get()
        ->each(function ($uraian) use ($request) {
          if ($uraian->parent_id) {
            $isi  = $uraian->isiBps->where('tahun', $request->tahun)->first();

            if (is_null($isi)) {
              $uraian->isiBps()->create([
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

  public function destroyTahun(TabelBps $tabel, int $tahun)
  {
    DB::beginTransaction();

    try {
      $tabel->uraian8KelData->each(fn ($uraian) => $uraian->isi8KelData()->where('tahun', $tahun)->delete());

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();

      return back()->with('error-message', $e->getMessage());
    }

    return back()->with('success-message', 'Deleted.');
  }

  public function chart(UraianBps $uraian)
  {
    return response()->json($this->service->getChartData($uraian), Response::HTTP_OK);
  }
}
