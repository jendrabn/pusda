<?php

namespace App\Http\Traits;

use App\Models\FileRpjmd;
use App\Models\FiturRpjmd;
use App\Models\TabelRpjmd;
use App\Models\UraianRpjmd;
use App\Models\User;
use App\Services\RpjmdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

trait RpjmdTrait
{

  private RpjmdService $service;

  public function __construct(RpjmdService $service)
  {
    $this->service = $service;
  }

  public function edit(Request $request, UraianRpjmd $uraian)
  {
    $isi = $this->service->getAllIsiByUraianId($uraian);
    $tahuns = $isi->map(fn ($item) => $item->tahun);
    $tabelId = $uraian->tabel_rpjmd_id;

    $viewPath = match (request()->user()->role) {
      User::ROLE_ADMIN => 'admin.isi-uraian.edit',
      User::ROLE_SKPD => 'skpd.isi-uraian.edit',
      default => null
    };

    abort_if(!$viewPath, Response::HTTP_NOT_FOUND);

    return view($viewPath, compact('uraian', 'isi', 'tahuns', 'tabelId'));
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

      throw new \Exception($e->getMessage());
    }

    return back()->with('success-message', 'Successfully Updated.');
  }

  public function destroy(UraianRpjmd $uraian)
  {
    $uraian->delete();

    return back()->with('success-message', 'Successfully Deleted.');
  }

  public function updateFitur(Request $request, TabelRpjmd $tabel)
  {
    $request->validate([
      'deskripsi' => ['nullable', 'string', 'max:255'],
      'analisis'  => ['nullable', 'string', 'max:255'],
      'permasalahan'  => ['nullable', 'string', 'max:255'],
      'solusi'  => ['nullable', 'string', 'max:255'],
      'saran'  => ['nullable', 'string', 'max:255']
    ]);

    $tabel->fiturRpjmd()->updateOrCreate([], $request->all());

    return back()->with('success-message', 'Successfully Updated');
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

    return back()->with('success-message', 'Successfully Saved.');
  }

  public function destroyFile(FileRpjmd $file)
  {
    Storage::disk('public')->delete($file->path);

    $file->delete();

    return back()->with('success-message', 'Successfully Deleted.');
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

    return response()->json(status: Response::HTTP_NO_CONTENT);
  }

  public function chart(UraianRpjmd $uraian)
  {
    return response()->json($this->service->getChartData($uraian), Response::HTTP_OK);
  }
}
