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
      $model = TabelIndikator::query()->with('parent')->select(sprintf('%s.*', (new TabelIndikator())->getTable()));
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
      'parent_id' =>  ['required', 'integer',  sprintf('exists:%s,id', (new TabelIndikator())->getTable())],
      'nama_menu' => ['required', 'string', 'max:255']
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
      'parent_id' =>  ['required', 'integer', sprintf('exists:%s,id', (new TabelIndikator())->getTable())],
      'nama_menu' => ['required', 'string', 'max:255']
    ]);

    if ($tabel->id !== 1) {
      $tabel->update($request->all());
    }

    return back()->with('success-message', 'Updated.');
  }

  public function destroy(TabelIndikator $tabel)
  {
    if ($tabel->id !== 1) {
      $tabel->delete();
    }

    return back()->with('success-message', 'Deleted.');
  }

  public function massDestroy(Request $request)
  {
    $request->validate([
      'ids' => ['required', 'array'],
      'ids.*', ['integer',  sprintf('exists:%s,id', (new TabelIndikator())->getTable())]
    ]);

    $ids = collect($request->ids)->filter(fn ($val, $key) => intval($val) !== 1)->toArray();

    TabelIndikator::whereIn('id', $ids)->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
