<?php

namespace App\Http\Controllers\Admin\TreeView;

use App\Http\Controllers\Controller;
use App\Models\TabelBps;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;


class BpsController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $model = TabelBps::with('parent')->select('tabel_bps.*');
      $table = DataTables::eloquent($model);

      $table->addColumn('placeholder', '&nbsp;');
      $table->addColumn('actions', '&nbsp;');
      $table->editColumn('actions', function ($row) {
        $crudRoutePart = 'treeview.bps';

        return view('partials.datatablesActions', compact(
          'crudRoutePart',
          'row'
        ));
      });

      $table->editColumn('parent', fn ($row) => $row->parent ? $row->parent->nama_menu : '');
      $table->rawColumns(['actions', 'placeholder']);

      return $table->toJson();
    }

    $categories = TabelBps::with(['parent', 'childs.childs.childs'])->get();
    $title = 'Menu Treeview BPS';
    $crudRoutePart = 'bps';

    return view('admin.treeview.index', compact('categories', 'crudRoutePart', 'title'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'parent_id' =>  ['required', 'numeric', 'exists:tabel_bps,id'],
      'nama_menu' => ['required', 'string']
    ]);

    TabelBps::create($request->all());

    return back()->with('success-message', 'Saved.');
  }

  public function edit(TabelBps $tabel)
  {
    $categories = TabelBps::with('parent')->get();
    $title = 'Menu Treeview BPS';
    $crudRoutePart = 'bps';

    return view('admin.treeview.edit', compact('tabel', 'categories', 'crudRoutePart', 'title'));
  }

  public function update(Request $request, TabelBps $tabel)
  {
    $request->validate([
      'parent_id' =>  ['required', 'numeric', 'exists:tabel_bps,id'],
      'nama_menu' => ['required', 'string']
    ]);

    if (intval($tabel->id) !== 1) {
      $tabel->update($request->all());

      return back()->with('success-message', 'Updated.');
    }

    return back()->with('error-message', 'Cannot Updated.');
  }

  public function destroy(TabelBps $tabel)
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
      'ids.*', ['integer', 'exists:tabel_bps,id']
    ]);

    $ids = collect($request->ids)->filter(fn ($val, $key) => $val != 1)->toArray();

    TabelBps::whereIn('id', $ids)->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
