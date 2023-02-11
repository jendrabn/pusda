<?php

namespace App\Http\Controllers\Admin\Uraian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TabelIndikator;
use App\Models\UraianIndikator;
use Symfony\Component\HttpFoundation\Response;

class IndikatorController extends Controller
{
  public function index(TabelIndikator $tabel = null)
  {
    $uraian = null;
    $categories = TabelIndikator::with('childs.childs.childs')->get();
    $title = 'Uraian Form Menu Indikator';
    $crudRoutePart = 'indikator';

    if ($tabel) {
      $uraian = UraianIndikator::with('childs')
        ->where('tabel_indikator_id', $tabel->id)
        ->whereNull('parent_id')
        ->orderBy('id')
        ->get();
    }

    return view('admin.uraian.index', compact('tabel', 'categories', 'title', 'crudRoutePart', 'uraian'));
  }

  public function store(Request $request, TabelIndikator $tabel)
  {
    // Kebanyakan ID SKPD null
    $request->merge([
      'skpd_id' => auth()->user()->skpd_id
    ]);

    $request->validate([
      'parent_id' => ['nullable', 'integer'],
      'uraian' => ['required', 'string', 'max:255'],
    ]);

    $tabel->uraianIndikator()->create($request->all());

    return back()->with('success-message', 'Saved.');
  }

  public function edit(TabelIndikator $tabel, UraianIndikator $uraian)
  {
    $categories = TabelIndikator::all();
    $uraians = UraianIndikator::with('childs')
      ->where('tabel_indikator_id', $tabel->id)
      ->whereNull('parent_id')
      ->orderBy('id')
      ->get();
    $title = 'Uraian Form Menu Indikator';
    $crudRoutePart = 'indikator';

    return view('admin.uraian.edit', compact('tabel', 'uraian', 'categories', 'uraians', 'title', 'crudRoutePart'));
  }

  public function update(Request $request, UraianIndikator $uraian)
  {
    $request->validate([
      'parent_id' => ['nullable', 'integer'],
      'uraian' => ['required', 'string', 'max:255'],
    ]);

    $uraian->update($request->all());

    return back()->with('success-message', 'Updated.');
  }

  public function destroy(UraianIndikator $uraian)
  {
    $uraian->delete();

    return back()->with('success-message', 'Deleted.');
  }

  public function massDestroy(Request $request)
  {
    $request->validate([
      'ids' => ['required', 'array'],
      'ids.*' => ['integer', sprintf('exists:%s,id', (new UraianIndikator())->getTable())]
    ]);

    UraianIndikator::whereIn('id', $request->ids)->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
