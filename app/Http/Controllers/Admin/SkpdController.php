<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SkpdsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skpd;
use App\Models\SkpdCategory;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SkpdController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $query = Skpd::with(['category'])->select('skpd.*');
            $table = DataTables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $crudRoutePart = 'skpd';

                return view('partials.datatablesActions', compact(
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });

            $table->editColumn('nama', function ($row) {
                return $row->nama ? $row->nama : '';
            });

            $table->editColumn('singkatan', function ($row) {
                return $row->singkatan ? $row->singkatan : '';
            });

            $table->editColumn('category', function ($row) {
                return $row->category ? $row->category->name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.skpd.index');
    }

    public function create()
    {
        $categories = SkpdCategory::pluck('name', 'id');
        $roles  = User::ROLES;

        return view('admin.skpd.create', compact('categories', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'singkatan' => ['required', 'string', 'max:100'],
            'skpd_kategori_id' => ['required', 'numeric', 'exists:skpd_categories,id']
        ]);

        Skpd::create($request->all());

        return redirect()->route('admin.skpd.index');
    }

    public function edit(Skpd $skpd)
    {
        $categories = SkpdCategory::all()->pluck('name', 'id');

        return view('admin.skpd.edit', compact('skpd', 'categories'));
    }

    public function update(Request $request, Skpd $skpd)
    {

        $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'singkatan' => ['required', 'string', 'max:100'],
            'skpd_kategori_id' => ['required', 'numeric', 'exists:skpd_categories,id']
        ]);

        $skpd->update($request->all());

        return redirect()->route('admin.skpd.index');
    }

    public function destroy(Request $request, Skpd $skpd)
    {
        $skpd->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        Skpd::whereIn('id', $request->ids)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
