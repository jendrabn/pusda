<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SkpdStoreRequest;
use App\Http\Requests\Admin\SkpdUpdateRequest;
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
      $model = Skpd::with('kategori')->select('skpd.*');
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

  public function store(SkpdStoreRequest $request)
  {
    Skpd::create($request->all());

    return back()->with('success-message', 'Saved.');
  }

  public function edit(Skpd $skpd)
  {
    $categories = KategoriSkpd::pluck('nama', 'id');

    return view('admin.skpd.edit', compact('skpd', 'categories'));
  }

  public function update(SkpdUpdateRequest $request, Skpd $skpd)
  {
    if (intval($skpd->id) !== 1) {
      $skpd->update($request->all());

      return back()->with('success-message', 'Updated.');
    }

    return back()->with('error-message', 'Cannot Updated.');
  }

  public function destroy(Skpd $skpd)
  {
    if (intval($skpd->id) !== 1) {
      $skpd->delete();

      return back()->with('success-message', 'Deleted.');
    }

    return back()->with('error-message', 'Cannot Deleted.');
  }

  public function massDestroy(Request $request)
  {
    $request->validate([
      'ids' => ['required', 'array'],
      'ids.*' => ['integer', 'exists:skpd,id']
    ]);

    $ids = collect($request->ids)->filter(fn ($id) => intval($id) !== 1)->toArray();

    Skpd::whereIn('id', $ids)->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
