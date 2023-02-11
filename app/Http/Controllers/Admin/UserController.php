<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MassDestroyUserRequest;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\Skpd;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $model = User::query()->with('skpd')->select(sprintf('%s.*', (new User())->getTable()));
      $table = Datatables::eloquent($model);

      $table->addColumn('placeholder', '&nbsp;');
      $table->addColumn('actions', '&nbsp;');

      $table->editColumn('actions', function ($row) {
        $crudRoutePart = 'users';

        return view('partials.datatablesActions', compact(
          'crudRoutePart',
          'row'
        ));
      });

      $table->editColumn('email', fn ($row) => $row->email
        ? sprintf('<a href="mailto:%s">%s</a>', $row->email, $row->email)
        : '');
      $table->editColumn('role', fn ($row) => $row->role
        ? sprintf('<span class="badge badge-info">%s</span>', $row->role)
        : '');

      $table->rawColumns(['actions', 'placeholder', 'email', 'role']);

      return $table->toJson();
    }

    return view('admin.user.index');
  }

  public function show(User $user)
  {
    return view('admin.user.show', compact('user'));
  }

  public function create()
  {
    $skpd = Skpd::pluck('nama', 'id');

    return view('admin.user.create', compact('skpd'));
  }

  public function store(StoreUserRequest $request)
  {
    User::create($request->validated());

    return back()->with('success-message', 'User successfully saved.');
  }

  public function edit(User $user)
  {
    $skpd = Skpd::pluck('nama', 'id');

    return view('admin.user.edit', compact('skpd', 'user'));
  }

  public function update(UpdateUserRequest $request, User $user)
  {
    $user->update($request->validated());

    return back()->with('success-message', 'User successfully updated.');
  }

  public function destroy(User $user)
  {
    Storage::disk('public')->delete($user->photo);

    $user->delete();

    return back()->with('success-message', 'User successfully deleted.');
  }

  public function massDestroy(MassDestroyUserRequest $request)
  {
    User::whereIn('id', $request->ids)->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
