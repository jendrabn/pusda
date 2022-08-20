<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skpd;
use App\Models\User;;

use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::all();
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

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });

            $table->editColumn('role', function ($row) {
                return sprintf('<span class="label label-info label-many">%s</span>', $row->role_name);
            });

            $table->rawColumns(['actions', 'placeholder', 'role']);

            return $table->make(true);
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

    public function store(Request $request)
    {

        $request->validate([
            'skpd_id' => ['required', 'numeric', 'exists:skpd,id'],
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'username' => ['required', 'string', 'min:3', 'max:25', 'alpha_dash', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'max:15', 'starts_with:+62,62,08'],
            'address' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'in:1,2'],
            'password' => ['required', 'string', 'min:3', 'max:50'],
        ]);

        User::create($request->all());

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        $skpd = Skpd::all()->pluck('nama', 'id');
        $roles = User::ROLES;

        return view('admin.users.edit', compact('skpd', 'user', 'roles'));
    }

    public function update(Request $request, User $user)
    {

        $request->validate([
            'skpd_id' => ['required', 'numeric', 'exists:skpd,id'],
            'name' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:25', 'alpha_dash', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'max:15', 'starts_with:+62,62,08'],
            'address' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'in:1,2'],
            'password' => ['nullable', 'string', 'min:3', 'max:50'],
        ]);

        $user->update($request->all());

        return redirect()->route('admin.users.index');
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        User::whereIn('id', $request->ids)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
