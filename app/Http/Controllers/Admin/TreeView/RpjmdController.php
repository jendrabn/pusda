<?php

namespace App\Http\Controllers\Admin\TreeView;

use App\Http\Controllers\Controller;
use App\Models\TabelRpjmd;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class RpjmdController extends Controller
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
      $model = TabelRpjmd::with('parent')->select('tabel_rpjmd.*');
      $table = DataTables::eloquent($model);

      $table->addColumn('placeholder', '&nbsp;');
      $table->addColumn('actions', '&nbsp;');
      $table->editColumn('actions', function ($row) {
        $crudRoutePart = 'treeview.rpjmd';

        return view('partials.datatablesActions', compact('crudRoutePart', 'row'));
      });
      $table->editColumn('parent', fn ($row) => $row->parent ? $row->parent->nama_menu : '');

      $table->rawColumns(['actions', 'placeholder']);

      return $table->toJson();
    }

    $categories = TabelRpjmd::with(['parent', 'childs.childs.childs'])->get();
    $title = 'Menu Treeview RPJMD';
    $crudRoutePart = 'rpjmd';

    return view('admin.treeview.index', compact(
      'categories',
      'title',
      'crudRoutePart'
    ));
  }

  /**
   * Undocumented function
   *
   * @param Request $request
   * @return RedirectResponse
   */
  public function store(Request $request): RedirectResponse
  {
    $request->merge(['skpd_id' => auth()->user()->skpd_id]);

    $validatedData = $request->validate([
      'parent_id' =>  [
        'required',
        'integer',
        'exists:tabel_rpjmd,id'
      ],
      'nama_menu' => [
        'required',
        'string',
        'min:1',
        'max:200'
      ],
      'skpd_id' => [
        'required',
        'integer',
        'exists:skpd,id'
      ]
    ]);

    TabelRpjmd::create($validatedData);

    toastr()->addSuccess('Saved.');

    return to_route('admin.treeview.rpjmd.index');
  }

  /**
   * Undocumented function
   *
   * @param TabelRpjmd $tabel
   * @return View
   */
  public function edit(TabelRpjmd $tabel): View
  {
    $categories = TabelRpjmd::with('parent')->get();
    $title = 'Menu Treeview RPJMD';
    $crudRoutePart = 'rpjmd';

    return view('admin.treeview.edit', compact(
      'categories',
      'tabel',
      'crudRoutePart',
      'title'
    ));
  }

  /**
   * Undocumented function
   *
   * @param Request $request
   * @param TabelRpjmd $tabel
   * @return RedirectResponse
   */
  public function update(Request $request, TabelRpjmd $tabel): RedirectResponse
  {
    $validatedData = $request->validate([
      'parent_id' =>  [
        'required',
        'integer',
        'exists:tabel_rpjmd,id'
      ],
      'nama_menu' => [
        'required',
        'string',
        'min:1',
        'max:200'
      ]
    ]);

    if ($tabel->id !== 1) $tabel->update($validatedData);

    toastr()->addSuccess('Updated.');

    return back();
  }

  /**
   * Undocumented function
   *
   * @param TabelRpjmd $tabel
   * @return RedirectResponse
   */
  public function destroy(TabelRpjmd $tabel): RedirectResponse
  {
    if ($tabel->id !== 1) $tabel->delete();

    toastr()->addSuccess('Deleted.');

    return to_route('admin.treeview.rpjmd.index');
  }

  /**
   * Undocumented function
   *
   * @param Request $request
   * @return HttpResponse
   */
  public function massDestroy(Request $request): HttpResponse
  {
    $validatedData = $request->validate([
      'ids' => [
        'required',
        'array'
      ],
      'ids.*', [
        'integer',
        'exists:tabel_rpjmd,id'
      ]
    ]);

    $ids = collect($validatedData['ids'])
      ->filter(fn ($val, $key) => (int) $val !== 1)
      ->toArray();

    TabelRpjmd::whereIn('id', $ids)->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
