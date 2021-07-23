<?php

namespace App\Http\Controllers\Admin\TreeView;

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
        return back()->with('alert-success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $tabelIndikator = TabelIndikator::findOrFail($id);
        $tabelIndikator->delete();
        $tabelIndikator->childs()->delete();

        return back()->with('alert-success', 'Data berhasil dihapus');
    }
}
