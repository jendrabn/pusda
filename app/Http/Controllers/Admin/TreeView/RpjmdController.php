<?php

namespace App\Http\Controllers\Admin\TreeView;

use App\Http\Controllers\Controller;
use App\Models\TabelRpjmd;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;


class RpjmdController extends Controller
{

  public function index(Request $request)
  {
    if ($request->ajax()) {
      $model = TabelRpjmd::query()->with('parent')->select(sprintf('%s.*', (new TabelRpjmd())->getTable()));
      $table = DataTables::eloquent($model);

      $table->addColumn('placeholder', '&nbsp;');
      $table->addColumn('actions', '&nbsp;');
      $table->editColumn('actions', function ($row) {
        $crudRoutePart = 'treeview.rpjmd';

        return view('partials.datatablesActions', compact(
          'crudRoutePart',
          'row'
        ));
      });
      $table->editColumn('parent', fn ($row) => $row->parent ? $row->parent->nama_menu : '');
      $table->rawColumns(['actions', 'placeholder']);

      return $table->toJson();
    }


    $categories = TabelRpjmd::with(['parent', 'childs.childs.childs'])->get();
    $title = 'Menu Treeview RPJMD';
    $crudRoutePart = 'rpjmd';

    return view('admin.treeview.index', compact('categories', 'title', 'crudRoutePart'));
  }

  public function store(Request $request)
  {
    $request->merge(['skpd_id' => auth()->user()->skpd_id]);

    $request->validate([
      'parent_id' =>  ['required', 'integer', sprintf('exists:%s,id', (new TabelRpjmd())->getTable())],
      'nama_menu' => ['required', 'string', 'max:255'],
      'skpd_id' => ['required', 'integer', 'exists:skpd,id']
    ]);

    TabelRpjmd::create($request->all());

    return back()->with('success-message', 'Saved.');
  }

  public function edit(TabelRpjmd $tabel)
  {
    $categories = TabelRpjmd::with('parent')->get();
    $title = 'Menu Treeview RPJMD';
    $crudRoutePart = 'rpjmd';

    return view('admin.treeview.edit', compact('categories', 'tabel', 'crudRoutePart', 'title'));
  }

  public function update(Request $request, TabelRpjmd $tabel)
  {
    $request->validate([
      'parent_id' =>  ['required', 'integer',     sprintf('exists:%s,id', (new TabelRpjmd())->getTable())],
      'nama_menu' => ['required', 'string', 'max:255']
    ]);

    if ($tabel->id !== 1) {
      $tabel->update($request->all());
    }

    return back()->with('success-message', 'Updated.');
  }

  public function destroy(TabelRpjmd $tabel)
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
      'ids.*', ['integer',     sprintf('exists:%s,id', (new TabelRpjmd())->getTable())]
    ]);

    $ids = collect($request->ids)->filter(fn ($val, $key) => intval($val) !== 1)->toArray();

    TabelRpjmd::whereIn('id', $ids)->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
