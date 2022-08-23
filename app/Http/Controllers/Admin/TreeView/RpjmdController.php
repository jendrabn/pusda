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
            $query = TabelRpjmd::all();
            $table = DataTables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $crudRoutePart = 'treeview.rpjmd';

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


        $categories = TabelRpjmd::with(['parent', 'childs.childs.childs'])->get();
        $crudRoutePart = 'rpjmd';
        $title = 'RPJMD';

        return view('admin.treeview.index', compact('categories', 'title', 'crudRoutePart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'parent_id' =>  ['required', 'numeric', 'exists:tabel_rpjmd,id'],
            'nama_menu' => ['required', 'string',]
        ]);

        $request->request->add([
            'skpd_id' => auth()->user()->skpd_id
        ]);

        TabelRpjmd::create($request->all());

        return back();
    }

    public function edit(TabelRpjmd $table)
    {
        $categories = TabelRpjmd::with('parent')->get();
        $crudRoutePart = 'rpjmd';
        $title = 'RPJMD';

        return view('admin.treeview.edit', compact('categories', 'table', 'crudRoutePart', 'title'));
    }

    public function update(Request $request, TabelRpjmd $table)
    {
        $request->validate([
            'parent_id' =>  ['required', 'numeric', 'exists:tabel_rpjmd,id'],
            'nama_menu' => ['required', 'string',]
        ]);

        if ($table->id != 1) {
            $table->update($request->all());
        }

        return back();
    }

    public function destroy(TabelRpjmd $table)
    {
        if ($table->id != 1) {
            $table->delete();
        }

        return back();
    }

    public function massDestroy(Request $request)
    {
        $ids = collect($request->ids)->filter(fn ($val, $key) => $val != 1)->toArray();

        TabelRpjmd::whereIn('id', $ids)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
