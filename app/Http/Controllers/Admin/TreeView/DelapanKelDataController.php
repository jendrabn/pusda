<?php

namespace App\Http\Controllers\Admin\TreeView;

use App\Events\UserLogged;
use App\Http\Controllers\Controller;
use App\Models\Tabel8KelData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DelapanKelDataController extends Controller
{

    public function index()
    {
        $categories = Tabel8KelData::with(['parent', 'childs.childs.childs'])->get();

        return view('admin.treeview.delapankeldata', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'parent_id' =>  ['required', 'numeric', 'exists:tabel_8keldata,id'],
            'nama_menu' => ['required', 'string', 'max:100']
        ]);

        $validated['skpd_id'] = Auth::user()->skpd->id;

        Tabel8KelData::create($validated);

        event(new UserLogged($request->user(), 'Menambahkan menu treeview 8 kelompok data'));

        return back()->with('alert-success', 'Berhasil menambahkan menu treeview 8 kelompok data');
    }

    public function edit($id)
    {
        $tabel8KelData = Tabel8KelData::findOrFail($id);
        $categories = Tabel8KelData::with('parent')->get();

        return view('admin.treeview.delapankeldata_edit', compact('categories', 'tabel8KelData'));
    }

    public function update(Request $request, $id)
    {
        $tabel8KelData = Tabel8KelData::findOrFail($id);

        $validated = $this->validate($request, [
            'parent_id' =>  ['required', 'numeric', 'exists:tabel_8keldata,id'],
            'nama_menu' => ['required', 'string', 'max:100']
        ]);

        $tabel8KelData->update($validated);

        event(new UserLogged($request->user(), 'Mengubah menu treeview 8 kelompok data'));

        return back()->with('alert-success', 'Menu treeview 8 kelompok data berhasil diupdate');
    }

    public function destroy(Request $request, $id)
    {
        $tabel8KelData = Tabel8KelData::findOrFail($id);
        $tabel8KelData->delete();

        event(new UserLogged($request->user(), 'Menghapus menu treeeview 8 kelompok data'));

        return back()->with('alert-success', 'Menu treeview 8 kelompok data berhasil dihapus');
    }
}
