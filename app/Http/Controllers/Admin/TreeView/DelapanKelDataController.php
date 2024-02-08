<?php

namespace App\Http\Controllers\Admin\TreeView;

use App\Http\Controllers\Controller;
use App\Models\Tabel8KelData;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DelapanKelDataController extends Controller
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
      $model = Tabel8KelData::with('parent')->select('tabel_8keldata.*');
      $table = DataTables::eloquent($model);

      $table->addColumn('placeholder', '&nbsp;');
      $table->addColumn('actions', '&nbsp;');
      $table->editColumn('actions', function ($row) {
        $crudRoutePart = 'treeview.delapankeldata';

        return view('partials.datatablesActions', compact('crudRoutePart', 'row'));
      });
      $table->editColumn('parent', fn ($row) =>   $row->parent ? $row->parent->nama_menu : '');

      $table->rawColumns(['actions', 'placeholder']);

      return $table->toJson();
    }

    $categories = Tabel8KelData::with(['parent', 'childs.childs'])->get();
    $title = 'Menu Treeview 8 Kel. Data';
    $crudRoutePart = 'delapankeldata';

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
        'exists:tabel_8keldata,id'
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

    Tabel8KelData::create($validatedData);

    toastr()->addSuccess('Saved.');

    return to_route('admin.treeview.delapankeldata.index');
  }

  /**
   * Undocumented function
   *
   * @param Tabel8KelData $tabel
   * @return View
   */
  public function edit(Tabel8KelData $tabel): View
  {
    $categories = Tabel8KelData::with('parent')->get();
    $title = 'Menu Treeview 8 Kel. Data';
    $crudRoutePart = 'delapankeldata';

    return view('admin.treeview.edit', compact(
      'categories',
      'tabel',
      'title',
      'crudRoutePart'
    ));
  }

  /**
   * Undocumented function
   *
   * @param Request $request
   * @param Tabel8KelData $tabel
   * @return RedirectResponse
   */
  public function update(Request $request, Tabel8KelData $tabel): RedirectResponse
  {
    $validatedData = $request->validate([
      'parent_id' =>  [
        'required',
        'integer',
        'exists:tabel_8keldata,id'
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
   * @param Tabel8KelData $tabel
   * @return RedirectResponse
   */
  public function destroy(Tabel8KelData $tabel): RedirectResponse
  {
    if ($tabel->id !== 1) $tabel->delete();

    toastr()->addSuccess('Deleted.');

    return to_route('admin.treeview.delapankeldata.index');
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
        'exists:tabel_8keldata,id'
      ]
    ]);

    $ids = collect($validatedData['ids'])
      ->filter(fn ($val, $key) => (int) $val !== 1)
      ->toArray();

    Tabel8KelData::whereIn('id', $ids)->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
