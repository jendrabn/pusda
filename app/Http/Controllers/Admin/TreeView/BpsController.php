<?php

namespace App\Http\Controllers\Admin\TreeView;

use App\Events\UserLogged;
use App\Http\Controllers\Controller;
use App\Models\TabelBps;
use Illuminate\Http\Request;

class BpsController extends Controller
{
    public function index()
    {
        $categories = TabelBps::with(['parent', 'childs.childs.childs'])->get();

        return view('admin.treeview.bps', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'parent_id' =>  ['required', 'numeric', 'exists:tabel_bps,id'],
            'nama_menu' => ['required', 'string', 'max:100']
        ]);

        TabelBps::create($validated);

        event(new UserLogged($request->user(), 'Menambahkan menu treeview BPS'));

        return back()->with('alert-success', 'Berhasil menambahkan menu treeview BPS');
    }

    public function edit($id)
    {
        $tabelBps = TabelBps::findOrFail($id);
        $categories = TabelBps::with('parent')->get();

        return view('admin.treeview.bps_edit', compact('categories', 'tabelBps'));
    }

    public function update(Request $request, $id)
    {
        $tabelBps = TabelBps::findOrFail($id);

        $validated = $this->validate($request, [
            'parent_id' =>  ['required', 'numeric', 'exists:tabel_bps,id'],
            'nama_menu' => ['required', 'string',  'max:100']
        ]);

        $tabelBps->update($validated);

        event(new UserLogged($request->user(), 'Mengubah menu treeview BPS'));

        return back()->with('alert-success', 'Menu treeview BPS berhasil diupdate');
    }

    public function destroy(Request $request, $id)
    {
        $tabelBps = TabelBps::findOrFail($id);
        $tabelBps->delete();

        event(new UserLogged($request->user(), 'Menghapus menu treeview BPS'));

        return back()->with('alert-success', 'Menu treeview BPS berhasil dihapus');
    }
}
