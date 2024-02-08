<?php

namespace App\Http\Controllers\Admin\Uraian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TabelBps;
use App\Models\UraianBps;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

class BpsController extends Controller
{
  /**
   * Undocumented function
   *
   * @param TabelBps|null $tabel
   * @return View
   */
  public function index(TabelBps $tabel = null): View
  {
    $uraian = null;

    $categories = TabelBps::with('childs.childs.childs')->get();
    $title = 'Uraian Form Menu BPS';
    $crudRoutePart = 'bps';

    if ($tabel) {
      $uraian = UraianBps::with('childs')
        ->where('tabel_bps_id', $tabel->id)
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
   * @param TabelBps $tabel
   * @return RedirectResponse
   */
  public function store(Request $request, TabelBps $tabel): RedirectResponse
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

    $tabel->uraianBps()->create($validatedData);

    toastr()->addSuccess('Saved.');

    return back();
  }

  /**
   * Undocumented function
   *
   * @param TabelBps $tabel
   * @param UraianBps $uraian
   * @return View
   */
  public function edit(TabelBps $tabel, UraianBps $uraian): View
  {
    $categories = TabelBps::all();
    $uraians = UraianBps::with('childs')
      ->where('tabel_Bps_id', $tabel->id)
      ->whereNull('parent_id')
      ->orderBy('id')
      ->get();
    $title = 'Uraian Form Menu BPS';
    $crudRoutePart = 'bps';

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
   * @param UraianBps $uraian
   * @return RedirectResponse
   */
  public function update(Request $request, UraianBps $uraian): RedirectResponse
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
   * @param UraianBps $uraian
   * @return RedirectResponse
   */
  public function destroy(UraianBps $uraian): RedirectResponse
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
        'exists:uraian_bps,id'
      ]
    ]);

    UraianBps::whereIn('id', $validatedData['ids'])->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
