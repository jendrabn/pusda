<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MassDestroySkpdRequest;
use App\Http\Requests\Admin\StoreSkpdRequest;
use App\Http\Requests\Admin\UpdateSkpdRequest;
use Illuminate\Http\Request;
use App\Models\Skpd;
use App\Models\KategoriSkpd;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SkpdController extends Controller
{
  /**
   * Undocumented function
   *
   * @param Request $request
   * @return JsonResponse|View
   */
  public function index(Request $request): JsonResponse|View
  {
    if ($request->ajax()) {
      $model = Skpd::with(['kategori'])->select(sprintf('%s.*', (new Skpd())->getTable()));
      $table = DataTables::eloquent($model);

      $table->addColumn('placeholder', '&nbsp;');
      $table->addColumn('actions', '&nbsp;');

      $table->editColumn('actions', function ($row) {
        $crudRoutePart = 'skpd';

        return view('partials.datatablesActions', compact('crudRoutePart', 'row'));
      });

      $table->editColumn('kategori', fn ($row) => $row->kategori ? $row->kategori->nama : '');

      $table->rawColumns(['actions', 'placeholder']);

      return $table->toJson();
    }

    return view('admin.skpd.index');
  }

  /**
   * Undocumented function
   *
   * @return View
   */
  public function create(): View
  {
    $categories = KategoriSkpd::pluck('nama', 'id');

    return view('admin.skpd.create', compact('categories'));
  }

  /**
   * Undocumented function
   *
   * @param StoreSkpdRequest $request
   * @return RedirectResponse
   */
  public function store(StoreSkpdRequest $request): RedirectResponse
  {
    Skpd::create($request->validated());

    toastr()->addSuccess('SKPD successfully saved.');

    return to_route('admin.skpd.index');
  }

  /**
   * Undocumented function
   *
   * @param Skpd $skpd
   * @return View
   */
  public function edit(Skpd $skpd): View
  {
    $categories = KategoriSkpd::pluck('nama', 'id');

    return view('admin.skpd.edit', compact('skpd', 'categories'));
  }

  /**
   * Undocumented function
   *
   * @param UpdateSkpdRequest $request
   * @param Skpd $skpd
   * @return RedirectResponse
   */
  public function update(UpdateSkpdRequest $request, Skpd $skpd): RedirectResponse
  {
    if ($skpd->id !== 1) $skpd->update($request->validated());

    toastr()->addSuccess('SKPD successfully updated.');

    return back();
  }

  /**
   * Undocumented function
   *
   * @param Skpd $skpd
   * @return RedirectResponse
   */
  public function destroy(Skpd $skpd): RedirectResponse
  {
    if ($skpd->id !== 1) $skpd->delete();

    toastr()->addSuccess('SKPD successfully deleted.');

    return back();
  }

  /**
   * Undocumented function
   *
   * @param MassDestroySkpdRequest $request
   * @return HttpResponse
   */
  public function massDestroy(MassDestroySkpdRequest $request): HttpResponse
  {
    $ids = collect($request->ids)->filter(fn ($id) => intval($id) !== 1)->toArray();

    Skpd::whereIn('id', $ids)->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
