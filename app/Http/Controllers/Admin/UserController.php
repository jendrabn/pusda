<?php

namespace App\Http\Controllers\Admin;

use App\Events\UserLogged;
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

    public function index()
    {
        $users = User::latest()->get();

        return view('admin.user.index', compact('users'));
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
        User::create($validated);
        event(new UserLogged($request->user(), "Menambah User Baru"));
        return redirect()->route('admin.users.index')->with('status', 'Berhasil menambahkan user');
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
        event(new UserLogged($request->user(), "Mengubah data User "));
        return back()->with('alert-success', 'User berhasil diupdate');
    }

    public function destroy(Request $request, User $user)
    {
        $user = $user->delete();
        event(new UserLogged($request->user(), "Menghapus data User "));
        return back()->with('alert-success', 'User berhasil dihapus');
    }
}
