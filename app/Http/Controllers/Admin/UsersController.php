<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use Illuminate\Http\Request;
use App\Models\Skpd;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{

  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = User::with(['skpd'])->select('users.*');
      $table = Datatables::of($query);

      $table->addColumn('placeholder', '&nbsp;');
      $table->addColumn('actions', '&nbsp;');

      $table->editColumn('actions', function ($row) {
        $crudRoutePart = 'users';
        return view('partials.datatablesActions', compact(
          'crudRoutePart',
          'row'
        ));
      });

      $table->editColumn('id', fn ($row) => $row->id ? $row->id : '');
      $table->editColumn('name', fn ($row) =>  $row->name ? $row->name : '');
      $table->editColumn('username', fn ($row) => $row->username ? $row->username : '');
      $table->editColumn('email', fn ($row) => $row->email ? sprintf('<a href="mailto:%s">%s</a>', $row->email, $row->email) : '');
      $table->editColumn('phone', fn ($row) => $row->phone ? $row->phone : '');
      $table->editColumn('address', fn ($row) => $row->address ? $row->address : '');
      $table->editColumn('skpd', fn ($row) => $row->skpd ? $row->skpd->nama : '');
      $table->editColumn('photo', fn ($row) => sprintf('<img src="%s" width="50px" height="50px">', $row->photo_url));
      $table->editColumn('role', fn ($row) => sprintf('<span class="badge badge-info">%s</span>', $row->role_name));

      $table->rawColumns(['actions', 'placeholder', 'role', 'photo', 'email']);

      return $table->toJson();
    }

    return view('admin.users.index');
  }

  public function show(User $user)
  {
    return view('admin.users.show', compact('user'));
  }

  public function create()
  {
    $skpd = Skpd::pluck('nama', 'id');
    $roles = User::ROLES;

    return view('admin.users.create', compact('skpd',  'roles'));
  }

  public function store(UserStoreRequest $request)
  {
    User::create($request->all());

    return redirect(route('admin.users.index'))->with('alert-success', 'Successfully added User.');
  }

  public function edit(User $user)
  {
    $skpd = Skpd::all()->pluck('nama', 'id');
    $roles = User::ROLES;

    return view('admin.users.edit', compact('skpd', 'user', 'roles'));
  }

  public function update(UserUpdateRequest $request, User $user)
  {
    $user->update($request->all());

    return back()->with('alert-success', 'User successfully updated.');
  }

  public function destroy(User $user)
  {
    $user->delete();

    return back()->with('alert-success', 'User successfully deleted.');
  }

  public function massDestroy(Request $request)
  {
    User::whereIn('id', $request->ids)->delete();

    return response(null, Response::HTTP_NO_CONTENT);
  }
}
