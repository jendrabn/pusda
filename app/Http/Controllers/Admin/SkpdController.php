<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SkpdStoreRequest;
use App\Http\Requests\Admin\SkpdUpdateRequest;
use Illuminate\Http\Request;
use App\Models\Skpd;
use App\Models\KategoriSkpd;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SkpdController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $query = Skpd::with(['kategori'])->select('skpd.*');
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

            $table->editColumn('id', fn ($row) => $row->id ? $row->id : '');
            $table->editColumn('nama', fn ($row) => $row->nama ? $row->nama : '');
            $table->editColumn('singkatan', fn ($row) => $row->singkatan ? $row->singkatan : '');
            $table->editColumn('kategori', fn ($row) => $row->kategori ? $row->kategori->nama : '');
            $table->rawColumns(['actions', 'placeholder']);

            return $table->toJson();
        }

        return view('admin.skpd.index');
    }

    public function create()
    {
        $categories = KategoriSkpd::pluck('nama', 'id');
        $roles  = User::ROLES;

        return view('admin.skpd.create', compact('categories', 'roles'));
    }

    public function store(SkpdStoreRequest $request)
    {
        Skpd::create($request->all());

        return redirect(route('admin.skpd.index'))->with('alert-success', 'Successfully added SKPD.');
    }

    public function edit(Skpd $skpd)
    {
        $categories = KategoriSkpd::all()->pluck('nama', 'id');

        return view('admin.skpd.edit', compact('skpd', 'categories'));
    }

    public function update(SkpdUpdateRequest $request, Skpd $skpd)
    {
        $skpd->update($request->all());

        return back()->with('alert-success', 'SKPD successfully updated.');
    }

    public function destroy(Skpd $skpd)
    {
        $skpd->delete();

        return back()->with('alert-success', 'SKPD successfully deleted.');
    }

    public function massDestroy(Request $request)
    {
        Skpd::whereIn('id', $request->ids)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
