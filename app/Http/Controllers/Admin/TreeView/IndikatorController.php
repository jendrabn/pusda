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
            $query = TabelIndikator::all();
            $table = DataTables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $crudRoutePart = 'treeview.indikator';

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


        $categories = TabelIndikator::with(['parent', 'childs.childs.childs'])->get();
        $crudRoutePart = 'indikator';
        $title = 'Indikator';

        return view('admin.treeview.index', compact('categories', 'title', 'crudRoutePart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'parent_id' =>  ['required', 'numeric', 'exists:tabel_indikator,id'],
            'nama_menu' => ['required', 'string']
        ]);

        TabelIndikator::create($request->all());

        return back();
    }

    public function edit(TabelIndikator $table)
    {
        $categories = TabelIndikator::with('parent')->get();
        $crudRoutePart = 'indikator';
        $title = 'Indikator';

        return view('admin.treeview.edit', compact('categories', 'table', 'title', 'crudRoutePart'));
    }

    public function update(Request $request, TabelIndikator $table)
    {
        $request->validate([
            'parent_id' =>  ['required', 'numeric', 'exists:tabel_8keldata,id'],
            'nama_menu' => ['required', 'string']
        ]);

        $table->update($request->all());

        return back();
    }

    public function destroy(TabelIndikator $table)
    {
        $table->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        TabelIndikator::whereIn('id', $request->ids)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
