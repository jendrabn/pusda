<?php

namespace App\Http\Controllers\Admin\TreeView;

use App\Http\Controllers\Controller;
use App\Models\TabelIndikator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class IndikatorController extends Controller
{

  public function index(Request $request)
  {
    if ($request->ajax()) {
      $model = TabelIndikator::with('parent')->select('tabel_indikator.*');
      $table = DataTables::eloquent($model);

      $table->addColumn('placeholder', '&nbsp;');
      $table->addColumn('actions', '&nbsp;');
      $table->editColumn('actions', function ($row) {
        $crudRoutePart = 'treeview.indikator';

        return view('partials.datatablesActions', compact(
          'crudRoutePart',
          'row'
        ));
      });
      $table->editColumn('parent', fn ($row) =>  $row->parent ? $row->parent->nama_menu : '');
      $table->rawColumns(['actions', 'placeholder']);

      return $table->toJson();
    }

    $categories = TabelIndikator::with(['parent', 'childs.childs.childs'])->get();
    $title = 'Menu Treeview Indikator';
    $crudRoutePart = 'indikator';

    return view('admin.treeview.index', compact('categories', 'title', 'crudRoutePart'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'parent_id' =>  ['required', 'integer', 'exists:tabel_indikator,id'],
      'nama_menu' => ['required', 'string', 'max:200']
    ]);

    TabelIndikator::create($request->all());

    return back()->with('success-message', 'Saved.');
  }

  public function edit(TabelIndikator $tabel)
  {
    $categories = TabelIndikator::with('parent')->get();
    $title = 'Menu Treeview Indikator';
    $crudRoutePart = 'indikator';

    return view('admin.treeview.edit', compact('categories', 'tabel', 'title', 'crudRoutePart'));
  }

  public function update(Request $request, TabelIndikator $tabel)
  {
    $request->validate([
      'parent_id' =>  ['required', 'integer', 'exists:tabel_indikator,id'],
      'nama_menu' => ['required', 'string', 'max:200']
    ]);

    if (intval($tabel->id) !== 1) {
      $tabel->update($request->all());

      return back()->with('success-message', 'Updated.');
    }

    return back()->with('error-message', 'Cannot Updated.');
  }

  public function destroy(TabelIndikator $tabel)
  {
    if (intval($tabel->id) !== 1) {
      $tabel->delete();

      return back()->with('success-message', 'Deleted.');
    }

    return back()->with('error-message', 'Cannot Deleted.');
  }

  public function massDestroy(Request $request)
  {
    $request->validate([
      'ids' => ['required', 'array'],
      'ids.*', ['integer', 'exists:tabel_indikator.id']
    ]);

    $ids = collect($request->ids)->filter(fn ($val, $key) => intval($val) !== 1)->toArray();

    TabelIndikator::whereIn('id', $ids)->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
