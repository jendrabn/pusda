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

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('nama_menu', function ($row) {
                return $row->nama_menu ? $row->nama_menu : '';
            });
            $table->editColumn('parent', function ($row) {
                return $row->parent ? $row->parent->nama_menu : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        $categories = Tabel8KelData::with(['parent', 'childs.childs.childs'])->get();
        $crudRoutePart = 'delapankeldata';
        $title = '8 Kel. Data';

        return view('admin.treeview.index', compact('categories', 'title', 'crudRoutePart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'parent_id' =>  ['required', 'numeric', 'exists:tabel_8keldata,id'],
            'nama_menu' => ['required', 'string']
        ]);

        $request->request->add(['skpd_id' => auth()->user()->skpd_id]);

        Tabel8KelData::create($request->all());

        return back();
    }

    public function edit(Tabel8KelData $table)
    {
        $categories = Tabel8KelData::with('parent')->get();
        $crudRoutePart = 'delapankeldata';
        $title = 'Menu 8 Kel. Data';

        return view('admin.treeview.edit', compact('categories', 'table', 'title', 'crudRoutePart'));
    }

    public function update(Request $request, Tabel8KelData $table)
    {
        $request->validate([
            'parent_id' =>  ['required', 'numeric', 'exists:tabel_8keldata,id'],
            'nama_menu' => ['required', 'string']
        ]);

        $table->update($request->all());

        return back();
    }

    public function destroy(Request $request, Tabel8KelData $table)
    {
        $table->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        Tabel8KelData::whereIn('id', $request->ids)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
