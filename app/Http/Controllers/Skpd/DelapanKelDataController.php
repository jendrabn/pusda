<?php

namespace App\Http\Controllers\Skpd;

use App\Http\Controllers\Controller;
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

    return view('skpd.isiUraian.index', compact('skpd', 'tabelIds', 'categories'));
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

    return view('skpd.isiUraian.input', compact('tabel', 'skpd', 'skpds',  'categories', 'uraians',  'fitur', 'files', 'tahuns'));
  }

  public function edit(Request $request, Uraian8KelData $uraian)
  {
    $isi = $this->service->getAllIsiByUraianId($uraian);
    $tahuns = $isi->map(fn ($item) => $item->tahun);
    $tabelId = $uraian->tabel_8keldata_id;

    return view('admin.isiUraian.edit', compact('uraian', 'isi', 'tahuns', 'tabelId'));
  }


  public function update(Request $request, Uraian8KelData $uraian)
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

  public function destroy(Uraian8KelData $uraian)
  {
    $uraian->delete();

    return back()->with('success-message', 'Deleted.');
  }

  public function updateFitur(Request $request, Fitur8KelData $fitur)
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

  public function storeFile(Request $request, Tabel8KelData $tabel)
  {
    $request->validate([
      'document' => ['required', 'max:10240'],
    ]);

    $file = $request->file('document');

    $tabel->file8KelData()->create([
      'nama' => $file->getClientOriginalName(),
      'path' => $file->storePublicly('file_pendukung', 'public')
    ]);

    return back()->with('success-message', 'Saved.');
  }

  public function destroyFile(File8KelData $file)
  {
    Storage::disk('public')->delete($file->path);

    $file->delete();

    return back()->with('success-message', 'Deleted.');
  }

  public function downloadFile(File8KelData $file)
  {
    return Storage::disk('public')->download($file->path, $file->nama);
  }

  public function updateSumberData(Request $request, Uraian8KelData $uraian)
  {
    $request->validate(['skpd_id' => ['required', 'integer', 'exists:skpd,id']]);

    $uraian->skpd_id = $request->skpd_id;
    $uraian->save();

    return response()->json([], Response::HTTP_NO_CONTENT);
  }
}
