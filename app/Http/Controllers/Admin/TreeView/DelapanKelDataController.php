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
      $query = Tabel8KelData::all();
      $table = DataTables::of($query);

      $table->addColumn('placeholder', '&nbsp;');
      $table->addColumn('actions', '&nbsp;');

      $table->editColumn('actions', function ($row) {
        $crudRoutePart = 'treeview.delapankeldata';

        return view('partials.datatablesActions', compact(
          'crudRoutePart',
          'row'
        ));
      });

      $table->editColumn('id', fn ($row) =>  $row->id ? $row->id : '');
      $table->editColumn('nama_menu', fn ($row) =>  $row->nama_menu ? $row->nama_menu : '');
      $table->editColumn('parent', fn ($row) =>   $row->parent ? $row->parent->nama_menu : '');

      $table->rawColumns(['actions', 'placeholder']);

      return $table->toJson();
    }

    $categories = Tabel8KelData::with(['parent', 'childs.childs.childs'])->get();
    $crudRoutePart = 'delapankeldata';
    $title = 'Menu Treeview 8 Kel. Data';

    return view('admin.treeview.index', compact('categories', 'title', 'crudRoutePart'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'parent_id' =>  ['required', 'integer', 'exists:tabel_8keldata,id'],
      'nama_menu' => ['required', 'string']
    ]);

    $request->request->add(['skpd_id' => auth()->user()->skpd_id]);

    Tabel8KelData::create($request->all());

    return back()->with('alert-success', 'Successfully added menu treeview 8 kel. data.');
  }

  public function edit(Tabel8KelData $table)
  {
    $categories = Tabel8KelData::with('parent')->get();
    $crudRoutePart = 'delapankeldata';
    $title = 'Menu Treeview 8 Kel. Data';

    return view('admin.treeview.edit', compact('categories', 'table', 'title', 'crudRoutePart'));
  }

  public function update(Request $request, Tabel8KelData $table)
  {
    $request->validate([
      'parent_id' =>  ['required', 'numeric', 'exists:tabel_8keldata,id'],
      'nama_menu' => ['required', 'string']
    ]);

    if ($table->id != 1) {
      $table->update($request->all());

      return redirect()->route('admin.treeview.delapankeldata.index')
        ->with('alert-success', 'Menu treeview 8 kel. data successfully updated.');
    }

    return back()->with('alert-fail', 'Menu "Parent" with ID 1 cannot updated.');
  }

  public function destroy(Request $request, Tabel8KelData $table)
  {
    if ($table->id != 1) {
      $table->delete();
      return back()->with('alert-success', 'Menu treeview 8 kel. data successfully deleted.');
    }

    return back()->with('alert-fail', 'Menu "Parent" with ID 1 cannot deleted.');
  }

  public function massDestroy(Request $request)
  {
    $ids = collect($request->ids)->filter(fn ($val, $key) => $val != 1)->toArray();

    Tabel8KelData::whereIn('id', $ids)->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
