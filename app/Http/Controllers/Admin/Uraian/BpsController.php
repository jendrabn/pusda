<?php

namespace App\Http\Controllers\Admin\Uraian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TabelBps;
use App\Models\UraianBps;
use Symfony\Component\HttpFoundation\Response;

class BpsController extends Controller
{

  public function index(TabelBps $tabel = null)
  {
    $uraian = null;

    $categories = TabelBps::with('childs.childs.childs')->get();
    $title = 'Uraian Form Menu BPS';
    $crudRoutePart = 'bps';

    if ($tabel) {
      $uraian = UraianBps::with('childs')
        ->where('tabel_bps_id', $tabel->id)
        ->whereNull('parent_id')
        ->orderBy('id')
        ->get();
    }

    return view('admin.uraian.index', compact('tabel', 'categories', 'title', 'crudRoutePart', 'uraian',));
  }

  public function store(Request $request, TabelBps $tabel)
  {
    // Kebanyakan ID SKPD null
    $request->merge([
      'skpd_id' => auth()->user()->skpd_id
    ]);

    $request->validate([
      'parent_id' => ['nullable', 'integer'],
      'uraian' => ['required', 'string', 'max:255'],
    ]);

    $tabel->uraianBps()->create($request->all());

    return back()->with('success-message', 'Saved.');
  }

  public function edit(TabelBps $tabel, UraianBps $uraian)
  {
    $categories = TabelBps::all();
    $uraians = UraianBps::with('childs')
      ->where('tabel_Bps_id', $tabel->id)
      ->whereNull('parent_id')
      ->orderBy('id')
      ->get();
    $title = 'Uraian Form Menu BPS';
    $crudRoutePart = 'bps';

    return view('admin.uraian.edit', compact('tabel', 'uraian', 'categories', 'uraians', 'title', 'crudRoutePart'));
  }

  public function update(Request $request, UraianBps $uraian)
  {
    $request->validate([
      'parent_id' => ['nullable', 'integer'],
      'uraian' => ['required', 'string', 'max:255'],
    ]);

    $uraian->update($request->all());

    return back()->with('success-message', 'Updated.');
  }

  public function destroy(UraianBps $uraian)
  {
    $uraian->delete();

    return back()->with('success-message', 'Deleted.');
  }

  public function massDestroy(Request $request)
  {
    $request->validate([
      'ids' => ['required', 'array'],
      'ids.*' => ['integer', 'exists:uraian_bps,id']
    ]);

    UraianBps::whereIn('id', $request->ids)->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
