<?php

namespace App\Http\Controllers\Admin\Uraian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TabelRpjmd;
use App\Models\UraianRpjmd;
use Symfony\Component\HttpFoundation\Response;

class RpjmdController extends Controller
{

  public function index(TabelRpjmd $tabel = null)
  {
    $uraian = null;
    $categories = TabelRpjmd::with('childs.childs.childs')->get();
    $title = 'Uraian Form Menu RPJMD';
    $crudRoutePart = 'rpjmd';

    if ($tabel) {
      $uraian = UraianRpjmd::with('childs')
        ->where('tabel_rpjmd_id', $tabel->id)
        ->whereNull('parent_id')
        ->orderBy('id')
        ->get();
    }

    return view('admin.uraian.index', compact('tabel', 'categories', 'title', 'crudRoutePart', 'uraian'));
  }

  public function store(Request $request, TabelRpjmd $tabel)
  {
    // Kebanyakan ID SKPD  null
    $request->merge([
      'skpd_id' => auth()->user()->skpd_id
    ]);

    $request->validate([
      'parent_id' => ['nullable', 'integer'],
      'uraian' => ['required', 'string', 'max:255'],
    ]);

    $tabel->uraianRpjmd()->create($request->all());

    return back()->with('success-message', 'Saved.');
  }

  public function edit(TabelRpjmd $tabel, UraianRpjmd $uraian)
  {
    $categories = TabelRpjmd::where('skpd_id', auth()->user()->skpd_id)->get();
    $uraians = UraianRpjmd::with('childs')
      ->where('tabel_rpjmd_id', $tabel->id)
      ->whereNull('parent_id')
      ->orderBy('id')
      ->get();
    $title = 'Uraian Form Menu RPJMD';
    $crudRoutePart = 'rpjmd';

    return view('admin.uraian.edit', compact('tabel', 'uraian', 'categories', 'uraians', 'title', 'crudRoutePart'));
  }

  public function update(Request $request, UraianRpjmd $uraian)
  {
    $request->validate([
      'parent_id' => ['nullable', 'integer'],
      'uraian' => ['required', 'string', 'max:255'],
    ]);

    $uraian->update($request->all());

    return back()->with('success-message', 'Updated.');
  }

  public function destroy(UraianRpjmd $uraian)
  {
    $uraian->delete();

    return back()->with('success-message', 'Deleted.');
  }

  public function massDestroy(Request $request)
  {
    $request->validate([
      'ids' => ['required', 'array'],
      'ids.*' => ['integer', 'exists:uraian_rpjmd,id']
    ]);

    UraianRpjmd::whereIn('id', $request->ids)->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
