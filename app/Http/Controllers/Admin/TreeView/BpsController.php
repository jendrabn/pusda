<?php

namespace App\Http\Controllers\Admin\TreeView;

use App\Http\Controllers\Controller;
use App\Models\TabelBps;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BpsController extends Controller
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
      $model = TabelBps::with('parent')->select('tabel_bps.*');
      $table = DataTables::eloquent($model);

      $table->addColumn('placeholder', '&nbsp;');
      $table->addColumn('actions', '&nbsp;');
      $table->editColumn('actions', function ($row) {
        $crudRoutePart = 'treeview.bps';

        return view('partials.datatablesActions', compact('crudRoutePart', 'row'));
      });
      $table->editColumn('parent', fn ($row) => $row->parent ? $row->parent->nama_menu : '');

      $table->rawColumns(['actions', 'placeholder']);

      return $table->toJson();
    }

    $categories = TabelBps::with(['parent', 'childs.childs.childs'])->get();
    $title = 'Menu Treeview BPS';
    $crudRoutePart = 'bps';

    return view('admin.treeview.index', compact(
      'categories',
      'crudRoutePart',
      'title'
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
    $validatedData = $request->validate([
      'parent_id' =>  [
        'required',
        'integer',
        'exists:tabel_bps,id'
      ],
      'nama_menu' => [
        'required',
        'string',
        'min:1',
        'max:255'
      ]
    ]);

    TabelBps::create($validatedData);

    toastr()->addSuccess('Saved.');

    return to_route('admin.treeview.bps.index');
  }

  /**
   * Undocumented function
   *
   * @param TabelBps $tabel
   * @return View
   */
  public function edit(TabelBps $tabel): View
  {
    $categories = TabelBps::with('parent')->get();
    $title = 'Menu Treeview BPS';
    $crudRoutePart = 'bps';

    return view('admin.treeview.edit', compact(
      'tabel',
      'categories',
      'crudRoutePart',
      'title'
    ));
  }

  /**
   * Undocumented function
   *
   * @param Request $request
   * @param TabelBps $tabel
   * @return RedirectResponse
   */
  public function update(Request $request, TabelBps $tabel): RedirectResponse
  {
    $validatedData = $request->validate([
      'parent_id' =>  [
        'required',
        'integer',
        'exists:tabel_bps,id'
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
   * @param TabelBps $tabel
   * @return RedirectResponse
   */
  public function destroy(TabelBps $tabel): RedirectResponse
  {
    if ($tabel->id !== 1) $tabel->delete();

    toastr()->addSuccess('Deleted.');

    return to_route('admin.treeview.bps.index');
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
        'exists:tabel_bps,id'
      ]
    ]);

    $ids = collect($validatedData['ids'])
      ->filter(fn ($val, $key) => (int) $val !== 1)
      ->toArray();

    TabelBps::whereIn('id', $ids)->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
