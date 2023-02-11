<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MassDestroySkpdRequest;
use App\Http\Requests\Admin\StoreSkpdRequest;
use App\Http\Requests\Admin\UpdateSkpdRequest;
use Illuminate\Http\Request;
use App\Models\Skpd;
use App\Models\KategoriSkpd;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SkpdController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $model = Skpd::query()->with('kategori')->select(sprintf('%s.*', (new Skpd())->getTable()));
      $table = DataTables::eloquent($model);

      $table->addColumn('placeholder', '&nbsp;');
      $table->addColumn('actions', '&nbsp;');

      $table->editColumn('actions', function ($row) {
        $crudRoutePart = 'skpd';

        return view('partials.datatablesActions', compact(
          'crudRoutePart',
          'row'
        ));
      });

      $table->editColumn('kategori', fn ($row) => $row->kategori ? $row->kategori->nama : '');
      $table->rawColumns(['actions', 'placeholder']);

      return $table->toJson();
    }

    return view('admin.skpd.index');
  }

  public function create()
  {
    $categories = KategoriSkpd::pluck('nama', 'id');

    return view('admin.skpd.create', compact('categories'));
  }

  public function store(StoreSkpdRequest $request)
  {
    Skpd::create($request->validated());

    return back()->with('success-message', 'SKPD successfully saved.');
  }

  public function edit(Skpd $skpd)
  {
    $categories = KategoriSkpd::pluck('nama', 'id');

    return view('admin.skpd.edit', compact('skpd', 'categories'));
  }

  public function update(UpdateSkpdRequest $request, Skpd $skpd)
  {
    if ($skpd->id !== 1) {
      $skpd->update($request->validated());
    }

    return back()->with('success-message', 'SKPD successfully updated.');
  }

  public function destroy(Skpd $skpd)
  {
    if ($skpd->id !== 1) {
      $skpd->delete();
    }

    return back()->with('success-message', 'SKPD successfully deleted.');
  }

  public function massDestroy(MassDestroySkpdRequest $request)
  {
    $ids = collect($request->ids)->filter(fn ($id) => intval($id) !== 1)->toArray();

    Skpd::whereIn('id', $ids)->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
