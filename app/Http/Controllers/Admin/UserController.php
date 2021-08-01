<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Models\Skpd;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('admin.user.index');
    }

    public function show(User $user)
    {
        return view('admin.user.show', compact('user'));
    }

    public function create()
    {
        $skpd = Skpd::all()->pluck('nama', 'id');

        return view('admin.user.create', compact('skpd'));
    }

    public function store(UserStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] =  Hash::make($request->password);
        $user = User::create($validated);
        save_user_log('Menambahkan user baru dengan nama ' . $user->name);

        return redirect()->route('admin.users.index')->with('alert-success', 'Berhasil menambahkan user baru');
    }

    public function edit(User $user)
    {
        $skpd = Skpd::all()->pluck('nama', 'id');

        return view('admin.user.edit', compact('skpd', 'user'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $validated = $request->validated();
        $validated['password'] =  $request->has('password') ? Hash::make($request->password) : $user->password;
        $validated['avatar'] = $user->avatar;

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = 'storage/' . $request->file('avatar')->store('images/avatars', 'public');
            Storage::disk('public')->delete($user->avatar_path);
        }

        $user->update($validated);
        save_user_log('Mengubah data user ' . $user->name);

        return back()->with('alert-success', 'Data user berhasil diupdate');
    }

    public function destroy(Request $request, User $user)
    {
        abort_if(!$request->ajax(), 404);

        $name = $user->name;
        $user = $user->delete();
        save_user_log('Menghapus user ' . $name);

        return response()->json([
            'success' => true,
            'message' => 'User bernama ' . $name . ' berhasil dihapus'
        ], 200);
    }
}
