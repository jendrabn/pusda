<?php

namespace App\Http\Controllers\Admin\TreeView;

use App\Events\UserLogged;
use App\Http\Controllers\Controller;
use App\Models\Skpd;
use App\Models\Tabel8KelData;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DelapanKelDataController extends Controller
{

    public function index(): View
    {
        $categories = Tabel8KelData::all();
        return view('admin.treeview.delapankeldata', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'parent_id' =>  ['required', 'numeric', 'exists:tabel_8keldata,id'],
            'menu_name' => ['required', 'string', 'max:100']
        ]);

        $validated['skpd_id'] = Auth::user()->skpd->id;

        Tabel8KelData::create($validated);
        event(new UserLogged($request->user(), "Menambah data baru pada menu treeview 8 Kelompok Data"));
        return back()->with('alert-success', 'Berhasil menambahkan data');
    }

    public function edit($id)
    {
        $tabel8KelData = Tabel8KelData::findOrFail($id);
        $categories = Tabel8KelData::all();

        return view('admin.treeview.delapankeldata-edit', compact('categories', 'tabel8KelData'));
    }

    public function update(Request $request, $id)
    {
        $tabel8KelData = Tabel8KelData::findOrFail($id);
        $validated = $this->validate($request, [
            'parent_id' =>  ['required', 'numeric', 'exists:tabel_8keldata,id'],
            'menu_name' => ['required', 'string', 'max:100']
        ]);

        $tabel8KelData->update($validated);
        event(new UserLogged($request->user(), "Mengubah data pada treeview <i>{$tabel8KelData->menu_name}</i> 8 Kelompok Data"));
        return back()->with('alert-success', 'Data berhasil diupdate');
    }

    public function destroy(Request $request, $id)
    {
        $tabel8KelData = Tabel8KelData::findOrFail($id);
        $tabel8KelData->delete();
        $tabel8KelData->childs()->delete();
        event(new UserLogged($request->user(), "Menghapus data treeeview <i>{$tabel8KelData->menu_name}</i>  pada 8 Kelompok Data"));
        return back()->with('alert-success', 'Data berhasil dihapus');
    }
}
