<?php

namespace App\Http\Controllers\Admin\Uraian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TabelRpjmd;
use App\Models\UraianRpjmd;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

class RpjmdController extends Controller
{

  /**
   * Undocumented function
   *
   * @param TabelRpjmd|null $tabel
   * @return View
   */
  public function index(TabelRpjmd $tabel = null): View
  {
    $uraian = null;
    $categories = TabelRpjmd::with('childs.childs.childs')->get();
    $title = 'Uraian Form Menu RPJMD';
    $crudRoutePart = 'rpjmd';

    if ($tabel) {
      $uraian = UraianRpjmd::with('childs')
        ->where('tabel_rpjmd_id', $tabel->id)
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
   * @param TabelRpjmd $tabel
   * @return RedirectResponse
   */
  public function store(Request $request, TabelRpjmd $tabel): RedirectResponse
  {
    // Kebanyakan ID SKPD  null
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

    $tabel->uraianRpjmd()->create($validatedData);

    toastr()->addSuccess('Saved.');

    return back();
  }

  /**
   * Undocumented function
   *
   * @param TabelRpjmd $tabel
   * @param UraianRpjmd $uraian
   * @return View
   */
  public function edit(TabelRpjmd $tabel, UraianRpjmd $uraian): View
  {
    $categories = TabelRpjmd::where('skpd_id', auth()->user()->skpd_id)->get();
    $uraians = UraianRpjmd::with('childs')
      ->where('tabel_rpjmd_id', $tabel->id)
      ->whereNull('parent_id')
      ->orderBy('id')
      ->get();
    $title = 'Uraian Form Menu RPJMD';
    $crudRoutePart = 'rpjmd';


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
   * @param UraianRpjmd $uraian
   * @return RedirectResponse
   */
  public function update(Request $request, UraianRpjmd $uraian): RedirectResponse
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
   * @param UraianRpjmd $uraian
   * @return RedirectResponse
   */
  public function destroy(UraianRpjmd $uraian): RedirectResponse
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
        'exists:uraian_rpjmd,id'
      ]
    ]);

    UraianRpjmd::whereIn('id', $validatedData['ids'])->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
