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
            $query = TabelBps::all();
            $table = DataTables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $crudRoutePart = 'treeview.bps';

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

        $categories = TabelBps::with(['parent', 'childs.childs.childs'])->get();
        $crudRoutePart = 'bps';
        $title = 'BPS';

        return view('admin.treeview.index', compact('categories', 'crudRoutePart', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'parent_id' =>  ['required', 'numeric', 'exists:tabel_bps,id'],
            'nama_menu' => ['required', 'string']
        ]);

        TabelBps::create($request->all());

        return back();
    }

    public function edit(TabelBps $table)
    {
        $categories = TabelBps::with('parent')->get();
        $crudRoutePart = 'bps';
        $title = 'BPS';

        return view('admin.treeview.edit', compact('table', 'categories', 'crudRoutePart', 'title'));
    }

    public function update(Request $request, TabelBps $table)
    {
        $request->validate([
            'parent_id' =>  ['required', 'numeric', 'exists:tabel_bps,id'],
            'nama_menu' => ['required', 'string']
        ]);

        $table->update($request->all());

        return back();
    }

    public function destroy(TabelBps $table)
    {
        $table->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        TabelBps::whereIn('id', $request->ids)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
