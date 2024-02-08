<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileIndikator;
use App\Models\TabelIndikator;
use App\Models\UraianIndikator;
use App\Services\IndikatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class IndikatorController extends Controller
{

  private IndikatorService $service;

  public function __construct(IndikatorService $service)
  {
    $this->service = $service;

    View::share([
      'crudRoutePart' => 'indikator',
      'title' => 'Indikator'
    ]);
  }

  public function index()
  {
    $categories = $this->service->getCategories();

    return view('admin.isiUraian.index', compact('categories'));
  }

  public function input(TabelIndikator $tabel)
  {
    $tahuns = $this->service->getAllTahun($tabel);
    $uraians = $this->service->getAllUraianByTabelId($tabel);
    $categories = $this->service->getCategories();
    $fitur = $tabel->fiturIndikator;
    $files = $tabel->fileIndikator;

    return view('admin.isiUraian.input', compact('categories', 'tabel', 'uraians',  'fitur', 'files', 'tahuns'));
  }

  public function edit(Request $request, UraianIndikator $uraian)
  {
    $isi = $this->service->getIsiByUraianId($uraian);
    $tahuns = $isi->map(fn ($item) => $item->tahun);
    $tabelId = $uraian->tabel_indikator_id;

    return view('admin.isiUraian.edit', compact('uraian', 'isi', 'tahuns', 'tabelId'));
  }

  public function update(Request $request, UraianIndikator $uraian)
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

      throw new \Exception($e->getMessage());
    }

    toastr()->addSuccess('');

    return back()->with('success-message', 'Successfully Updated.');
  }

  public function destroy(UraianIndikator $uraian)
  {
    $uraian->delete();

    toastr()->addSuccess('');

    return back()->with('success-message', 'Successfully Deleted.');
  }

  public function updateFitur(Request $request, TabelIndikator $tabel)
  {
    $request->validate([
      [
        'deskripsi' => ['nullable', 'string', 'max:255'],
        'analisis'  => ['nullable', 'string', 'max:255'],
        'permasalahan'  => ['nullable', 'string', 'max:255'],
        'solusi'  => ['nullable', 'string', 'max:255'],
        'saran'  => ['nullable', 'string', 'max:255']
      ]
    ]);

    $tabel->fiturIndikator()->updateOrCreate([], $request->all());

    toastr()->addSuccess('');

    return back()->with('success-message', 'Successfully Updated.');
  }

  public function storeFile(Request $request, TabelIndikator $tabel)
  {
    $request->validate([
      'document' => ['required', 'max:10240'],
    ]);

    $file = $request->file('document');

    $tabel->fileIndikator()->create([
      'nama' => $file->getClientOriginalName(),
      'path' => $file->storePublicly('file_pendukung', 'public')
    ]);

    toastr()->addSuccess('');

    return back()->with('success-message', 'Successfully Saved.');
  }

  public function destroyFile(FileIndikator $file)
  {
    Storage::disk('public')->delete($file->path);

    $file->delete();

    toastr()->addSuccess('');

    return back()->with('success-message', 'Successfully Deleted.');
  }

  public function downloadFile(FileIndikator $file)
  {
    return Storage::disk('public')->download($file->path, $file->nama);
  }

  public function storeTahun(Request $request, TabelIndikator $tabel)
  {
    $request->validate([
      'tahun' => ['required', 'integer', 'min:2010', 'max:2030'],
    ]);

    DB::beginTransaction();
    try {
      $tabel->uraianIndikator()->with('isiIndikator')->get()
        ->each(function ($uraian) use ($request) {
          if ($uraian->parent_id) {
            $uraian->isiIndikator()->where('tahun', $request->tahun)->firstOrCreate([
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

    toastr()->addSuccess('');

    return back()->with('success-message', 'Successfully Saved.');
  }

  public function destroyTahun(TabelIndikator $tabel, int $tahun)
  {
    DB::beginTransaction();
    try {
      $tabel->uraianIndikator->each(fn ($uraian) => $uraian->isiIndikator()->where('tahun', $tahun)->delete());

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();

      throw new \Exception($e->getMessage());
    }
    toastr()->addSuccess('');

    return back()->with('success-message', 'Successfully Deleted.');
  }

  public function chart(UraianIndikator $uraian)
  {
    return response()->json($this->service->getChartData($uraian), Response::HTTP_OK);
  }
}
