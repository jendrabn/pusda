<?php

namespace App\Http\Controllers\Admin\TreeView;

use App\Http\Controllers\Controller;
use App\Models\Tabel8KelData;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DelapanKelDataController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $model = Tabel8KelData::with('parent')->select('tabel_8keldata.*');
      $table = DataTables::eloquent($model);

      $table->addColumn('placeholder', '&nbsp;');
      $table->addColumn('actions', '&nbsp;');
      $table->editColumn('actions', function ($row) {
        $crudRoutePart = 'treeview.delapankeldata';

        return view('partials.datatablesActions', compact(
          'crudRoutePart',
          'row'
        ));
      });
      $table->editColumn('parent', fn ($row) =>   $row->parent ? $row->parent->nama_menu : '');
      $table->rawColumns(['actions', 'placeholder']);

      return $table->toJson();
    }

    $categories = Tabel8KelData::with(['parent', 'childs.childs'])->get();
    $title = 'Menu Treeview 8 Kel. Data';
    $crudRoutePart = 'delapankeldata';

    return view('admin.treeview.index', compact('categories', 'title', 'crudRoutePart'));
  }

  public function store(Request $request)
  {
    $request->merge(['skpd_id' => auth()->user()->skpd_id]);

    $request->validate([
      'parent_id' =>  ['required', 'integer', 'exists:tabel_8keldata,id'],
      'nama_menu' => ['required', 'string', 'max:200'],
      'skpd_id' => ['required', 'integer', 'exists:skpd,id']
    ]);

    Tabel8KelData::create($request->all());

    return back()->with('success-message', 'Saved.');
  }

  public function edit(Tabel8KelData $tabel)
  {
    $categories = Tabel8KelData::with('parent')->get();
    $title = 'Menu Treeview 8 Kel. Data';
    $crudRoutePart = 'delapankeldata';

    return view('admin.treeview.edit', compact('categories', 'tabel', 'title', 'crudRoutePart'));
  }

  public function update(Request $request, Tabel8KelData $tabel)
  {
    $request->validate([
      'parent_id' =>  ['required', 'integer', 'exists:tabel_8keldata,id'],
      'nama_menu' => ['required', 'string', 'max:200']
    ]);

    if (intval($tabel->id) !== 1) {
      $tabel->update($request->all());

      return back()->with('success-message', 'Updated.');
    }

    return back()->with('error-message', 'Cannot Updated.');
  }

  public function destroy(Tabel8KelData $tabel)
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
      'ids.*', ['integer', 'exists:tabel_8keldata,id']
    ]);

    $ids = collect($request->ids)->filter(fn ($val, $key) => intval($val) !== 1)->toArray();

    Tabel8KelData::whereIn('id', $ids)->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
