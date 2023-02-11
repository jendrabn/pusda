<?php

namespace App\Http\Controllers\Admin\Uraian;

use App\Http\Controllers\Controller;
use App\Models\Tabel8KelData;
use App\Models\Uraian8KelData;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DelapanKelDataController extends Controller
{
  public function index(Tabel8KelData $tabel = null)
  {
    $uraian = null;

    $categories = Tabel8KelData::with('childs.childs.childs')->get();
    $title = 'Uraian Form Menu 8 Kelompok Data';
    $crudRoutePart = 'delapankeldata';

    if ($tabel) {
      $uraian = Uraian8KelData::with('childs')
        ->where('tabel_8keldata_id', $tabel->id)
        ->whereNull('parent_id')
        ->orderBy('id')
        ->get();
    }

    return view('admin.uraian.index', compact('tabel', 'categories', 'title', 'crudRoutePart', 'uraian'));
  }

  public function store(Request $request, Tabel8KelData $tabel)
  {
    // Kebanyakan ID SKPD tidak null
    $request->merge([
      'skpd_id' => auth()->user()->skpd_id
    ]);

    $request->validate([
      'parent_id' => ['nullable', 'integer'],
      'uraian' => ['required', 'string', 'max:255'],
      'skpd_id' => ['required', 'integer', 'exists:skpd,id']
    ]);

    $tabel->uraian8KelData()->create($request->all());

    return back()->with('success-message', 'Saved.');
  }

  public function edit(Tabel8KelData $tabel, Uraian8KelData $uraian)
  {
    $categories = Tabel8KelData::all();
    $uraians = Uraian8KelData::with('childs')
      ->where('tabel_8keldata_id', $tabel->id)
      ->whereNull('parent_id')
      ->orderBy('id')
      ->get();
    $title = 'Uraian Form Menu 8 Kelompok Data';
    $crudRoutePart = 'delapankeldata';

    return view('admin.uraian.edit', compact('tabel', 'uraian', 'categories',  'uraians',  'title', 'crudRoutePart'));
  }

  public function update(Request $request, Uraian8KelData $uraian)
  {
    $request->validate([
      'parent_id' => ['nullable', 'integer'],
      'uraian' => ['required', 'string', 'max:255'],
    ]);

    $uraian->update($request->all());

    return back()->with('success-message', 'Updated.');
  }

  public function destroy(Uraian8KelData $uraian)
  {
    $uraian->delete();

    return back()->with('success-message', 'Deleted.');
  }

  public function massDestroy(Request $request)
  {
    $request->validate([
      'ids' => ['required', 'array'],
      'ids.*' => ['integer', sprintf('exists:%s,id', (new Uraian8KelData())->getTable())]
    ]);

    Uraian8KelData::whereIn('id', $request->ids)->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
