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
      $model = TabelRpjmd::with('parent')->select('tabel_rpjmd.*');
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
      'parent_id' =>  ['required', 'integer', 'exists:tabel_rpjmd,id'],
      'nama_menu' => ['required', 'string', 'max:200'],
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
      'parent_id' =>  ['required', 'integer', 'exists:tabel_rpjmd,id'],
      'nama_menu' => ['required', 'string', 'max:200']
    ]);

    if (intval($tabel->id) !== 1) {
      $tabel->update($request->all());

      return back()->with('success-message', 'Updated.');
    }

    return back()->with('error-message', 'Cannot Updated.');
  }

  public function destroy(TabelRpjmd $tabel)
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
      'ids.*', ['integer', 'exists:tabel_rpjmd,id']
    ]);

    $ids = collect($request->ids)->filter(fn ($val, $key) => intval($val) !== 1)->toArray();

    TabelRpjmd::whereIn('id', $ids)->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
