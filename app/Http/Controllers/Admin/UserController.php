<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MassDestroyUserRequest;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\Skpd;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
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
      $model = User::with(['skpd'])->select(sprintf('%s.*', (new User())->getTable()));
      $table = Datatables::eloquent($model);

      $table->addColumn('placeholder', '&nbsp;');
      $table->addColumn('actions', '&nbsp;');

      $table->editColumn('actions', function ($row) {
        $crudRoutePart = 'users';

        return view('partials.datatablesActions', compact('crudRoutePart', 'row'));
      });

      $table->editColumn('role', fn ($row) => sprintf(
        '<span class="badge badge-info rounded-0">%s</span>',
        $row->role
      ));

      $table->rawColumns(['actions', 'placeholder', 'role']);

      return $table->toJson();
    }

    return view('admin.users.index');
  }

  /**
   * Undocumented function
   *
   * @param User $user
   * @return View
   */
  public function show(User $user): View
  {
    return view('admin.users.show', compact('user'));
  }

  /**
   * Undocumented function
   *
   * @return View
   */
  public function create(): View
  {
    $skpd = Skpd::pluck('nama', 'id');

    return view('admin.users.create', compact('skpd'));
  }

  /**
   * Undocumented function
   *
   * @param StoreUserRequest $request
   * @return RedirectResponse
   */
  public function store(StoreUserRequest $request): RedirectResponse
  {
    User::create($request->validated());

    toastr()->addSuccess('User successfully saved.');

    return back();
  }

  /**
   * Undocumented function
   *
   * @param User $user
   * @return View
   */
  public function edit(User $user): View
  {
    $skpd = Skpd::pluck('nama', 'id');

    return view('admin.users.edit', compact('skpd', 'user'));
  }

  /**
   * Undocumented function
   *
   * @param UpdateUserRequest $request
   * @param User $user
   * @return RedirectResponse
   */
  public function update(UpdateUserRequest $request, User $user): RedirectResponse
  {
    $user->update($request->validated());

    toastr()->addSuccess('User successfully updated.');

    return back();
  }

  /**
   * Undocumented function
   *
   * @param User $user
   * @return RedirectResponse
   */
  public function destroy(User $user): RedirectResponse
  {
    Storage::disk('public')->delete($user->photo);

    $user->delete();

    toastr()->addSuccess('User successfully deleted.');

    return back();
  }

  /**
   * Undocumented function
   *
   * @param MassDestroyUserRequest $request
   * @return void
   */
  public function massDestroy(MassDestroyUserRequest $request): HttpResponse
  {
    User::whereIn('id', $request->ids)->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
