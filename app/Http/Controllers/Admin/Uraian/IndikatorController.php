<?php

namespace App\Http\Controllers\Admin\Uraian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TabelIndikator;
use App\Models\UraianIndikator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

class IndikatorController extends Controller
{
  /**
   * Undocumented function
   *
   * @param TabelIndikator|null $tabel
   * @return View
   */
  public function index(TabelIndikator $tabel = null): View
  {
    $uraian = null;
    $categories = TabelIndikator::with('childs.childs.childs')->get();
    $title = 'Uraian Form Menu Indikator';
    $crudRoutePart = 'indikator';

    if ($tabel) {
      $uraian = UraianIndikator::with('childs')
        ->where('tabel_indikator_id', $tabel->id)
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
   * @param TabelIndikator $tabel
   * @return RedirectResponse
   */
  public function store(Request $request, TabelIndikator $tabel): RedirectResponse
  {
    // Kebanyakan ID SKPD null
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
    ]);

    $tabel->uraianIndikator()->create($validatedData);

    toastr()->addSuccess('Saved.');

    return back();
  }

  /**
   * Undocumented function
   *
   * @param TabelIndikator $tabel
   * @param UraianIndikator $uraian
   * @return View
   */
  public function edit(TabelIndikator $tabel, UraianIndikator $uraian): View
  {
    $categories = TabelIndikator::all();
    $uraians = UraianIndikator::with('childs')
      ->where('tabel_indikator_id', $tabel->id)
      ->whereNull('parent_id')
      ->orderBy('id')
      ->get();
    $title = 'Uraian Form Menu Indikator';
    $crudRoutePart = 'indikator';

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
   * @param UraianIndikator $uraian
   * @return RedirectResponse
   */
  public function update(Request $request, UraianIndikator $uraian): RedirectResponse
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
   * @param UraianIndikator $uraian
   * @return RedirectResponse
   */
  public function destroy(UraianIndikator $uraian): RedirectResponse
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
        'exists:uraian_indikator,id'
      ]
    ]);

    UraianIndikator::whereIn('id', $validatedData['ids'])->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
