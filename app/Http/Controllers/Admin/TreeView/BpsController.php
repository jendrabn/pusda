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
        $categories = TabelBps::all();

        return view('admin.treeview.bps', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'parent_id' =>  ['required', 'numeric', 'exists:tabel_bps,id'],
            'menu_name' => ['required', 'string', 'max:100']
        ]);

        TabelBps::create($validated);
        event(new UserLogged($request->user(), "Menambah data baru pada menu treeview BPS"));
        return back()->with('alert-success', 'Berhasil menambahkan data');
    }

    public function edit($id)
    {
        $tabelBps = TabelBps::findOrFail($id);
        $categories = TabelBps::all();

        return view('admin.treeview.bps-edit', compact('categories', 'tabelBps'));
    }

    public function update(Request $request, $id)
    {
        $tabelBps = TabelBps::findOrFail($id);
        $validated = $this->validate($request, [
            'parent_id' =>  ['required', 'numeric', 'exists:tabel_bps,id'],
            'menu_name' => ['required', 'string',  'max:100']
        ]);

        $tabelBps->update($validated);
        $tabelBps->menu_name = $request->menu_name;
        event(new UserLogged($request->user(), "Mengubah data pada treeview <i>{$tabelBps->menu_name}</i> BPS"));
        return back()->with('alert-success', 'Data berhasil diupdate');
    }

    public function destroy(Request $request, $id)
    {
        $tabelBps = TabelBps::findOrFail($id);
        $tabelBps->delete();
        $tabelBps->childs()->delete();
        event(new UserLogged($request->user(), "Menghapus data treeeview <i>{$tabelBps->menu_name}</i>  pada BPS"));
        return back()->with('alert-success', 'Data berhasil dihapus');
    }
}
