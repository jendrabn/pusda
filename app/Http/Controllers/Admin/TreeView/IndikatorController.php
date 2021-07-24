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
            'menu_name' => ['required', 'string', 'max:100']
        ]);

        TabelIndikator::create($validated);
        event(new UserLogged($request->user(), "Menambah data baru pada menu treeview Indikator"));
        return back()->with('alert-success', 'Berhasil menambahkan data');
    }

    public function edit($id)
    {
        $tabelIndikator = TabelIndikator::findOrFail($id);
        $categories = TabelIndikator::all();

        return view('admin.treeview.indikator-edit', compact('categories', 'tabelIndikator'));
    }

    public function update(Request $request, $id)
    {

        $tabelIndikator = TabelIndikator::findOrFail($id);

        $validated = $this->validate($request, [
            'parent_id' =>  ['required', 'numeric', 'exists:tabel_8keldata,id'],
            'menu_name' => ['required', 'string', 'max:100']
        ]);

        $tabelIndikator->update($validated);
        $tabelIndikator->menu_name = $request->menu_name;
        event(new UserLogged($request->user(), "Mengubah data pada treeview <i>{$tabelIndikator->menu_name}</i> Indikator"));
        return back()->with('alert-success', 'Data berhasil diupdate');
    }

    public function destroy(Request $request, $id)
    {
        $tabelIndikator = TabelIndikator::findOrFail($id);
        $tabelIndikator->delete();
        $tabelIndikator->childs()->delete();
        event(new UserLogged($request->user(), "Menghapus data treeeview <i>{$tabelIndikator->menu_name}</i>  pada Indikator"));
        return back()->with('alert-success', 'Data berhasil dihapus');
    }
}
