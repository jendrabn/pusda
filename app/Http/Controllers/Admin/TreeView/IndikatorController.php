<?php

namespace App\Http\Controllers\Admin\TreeView;

use App\Events\UserLogged;
use App\Http\Controllers\Controller;
use App\Models\TabelIndikator;
use Illuminate\Http\Request;

class IndikatorController extends Controller
{

    public function index()
    {
        $categories = TabelIndikator::all();

        return view('admin.treeview.indikator', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'parent_id' =>  ['required', 'numeric', 'exists:tabel_indikator,id'],
            'nama_menu' => ['required', 'string', 'max:100']
        ]);

        TabelIndikator::create($validated);

        event(new UserLogged($request->user(), 'Menambahkan menu treeview indikator'));

        return back()->with('alert-success', 'Berhasil menambahkan menu treeview indikator');
    }

    public function edit($id)
    {
        $tabelIndikator = TabelIndikator::findOrFail($id);

        $categories = TabelIndikator::all();

        return view('admin.treeview.indikator_edit', compact('categories', 'tabelIndikator'));
    }

    public function update(Request $request, $id)
    {
        $tabelIndikator = TabelIndikator::findOrFail($id);

        $validated = $this->validate($request, [
            'parent_id' =>  ['required', 'numeric', 'exists:tabel_8keldata,id'],
            'nama_menu' => ['required', 'string', 'max:100']
        ]);

        $tabelIndikator->update($validated);

        event(new UserLogged($request->user(), 'Mengubah menu treeview indikator'));

        return back()->with('alert-success', 'Menu treeview indikator berhasil diupdate');
    }

    public function destroy(Request $request, $id)
    {
        $tabelIndikator = TabelIndikator::findOrFail($id);
        $tabelIndikator->delete();

        event(new UserLogged($request->user(), 'Menghapus menu treeeview indikator'));

        return back()->with('alert-success', 'Menu treeview indikator berhasil dihapus');
    }
}
