<?php

namespace App\Http\Controllers\Admin\Uraian;

use App\Http\Controllers\Controller;
use App\Models\Tabel8KelData;
use App\Models\Uraian8KelData;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

class DelapanKelDataController extends Controller
{
  /**
   * Undocumented function
   *
   * @param Tabel8KelData|null $tabel
   * @return View
   */
  public function index(Tabel8KelData $tabel = null): View
  {
    $uraian = null;

    $categories = Tabel8KelData::with('childs.childs.childs')->get();
    $title = 'Uraian Form Menu 8 Kelompok Data';
    $crudRoutePart = 'delapankeldata';

    if ($tabel) {
      $uraian = Uraian8KelData::with('childs')
        ->where('tabel_8keldata_id', $tabel->id)
        ->whereNull('parent_id')
        ->orderBy('id')
        ->get();
    }

    return view('admin.uraian.index', compact(
      'tabel',
      'categories',
      'title',
      'crudRoutePart',
      'uraian'
    ));
  }

  /**
   * Undocumented function
   *
   * @param Request $request
   * @param Tabel8KelData $tabel
   * @return RedirectResponse
   */
  public function store(Request $request, Tabel8KelData $tabel): RedirectResponse
  {
    // Kebanyakan ID SKPD tidak null
    $request->merge(['skpd_id' => auth()->user()->skpd_id]);

    $validatedData = $request->validate([
      'parent_id' => [
        'nullable',
        'integer'
      ],
      'uraian' => [
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

    $tabel->uraian8KelData()->create($validatedData);

    toastr()->addSuccess('Saved.');

    return back();
  }

  /**
   * Undocumented function
   *
   * @param Tabel8KelData $tabel
   * @param Uraian8KelData $uraian
   * @return View
   */
  public function edit(Tabel8KelData $tabel, Uraian8KelData $uraian): View
  {
    $categories = Tabel8KelData::all();
    $uraians = Uraian8KelData::with('childs')
      ->where('tabel_8keldata_id', $tabel->id)
      ->whereNull('parent_id')
      ->orderBy('id')
      ->get();
    $title = 'Uraian Form Menu 8 Kelompok Data';
    $crudRoutePart = 'delapankeldata';

    return view('admin.uraian.edit', compact(
      'tabel',
      'uraian',
      'categories',
      'uraians',
      'title',
      'crudRoutePart'
    ));
  }

  /**
   * Undocumented function
   *
   * @param Request $request
   * @param Uraian8KelData $uraian
   * @return RedirectResponse
   */
  public function update(Request $request, Uraian8KelData $uraian): RedirectResponse
  {
    $validatedData = $request->validate([
      'parent_id' => [
        'nullable',
        'integer'
      ],
      'uraian' => [
        'required',
        'string',
        'min:1',
        'max:200'
      ],
    ]);

    $uraian->update($validatedData);

    toastr()->addSuccess('Updated.');

    return back();
  }

  /**
   * Undocumented function
   *
   * @param Uraian8KelData $uraian
   * @return RedirectResponse
   */
  public function destroy(Uraian8KelData $uraian): RedirectResponse
  {
    $uraian->delete();

    toastr()->addSuccess('Deleted.');

    return back();
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
      'ids.*' => [
        'integer',
        'exists:uraian_8keldata,id'
      ]
    ]);

    Uraian8KelData::whereIn('id', $validatedData['ids'])->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
