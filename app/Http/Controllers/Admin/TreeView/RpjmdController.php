<?php

namespace App\Http\Controllers\Admin\TreeView;

use App\Http\Controllers\Controller;
use App\Models\TabelRpjmd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RpjmdController extends Controller
{

    public function index()
    {
        $categories = TabelRpjmd::with(['parent', 'childs.childs.childs'])->get();

        return view('admin.treeview.rpjmd', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'parent_id' =>  ['required', 'numeric', 'exists:tabel_rpjmd,id'],
            'nama_menu' => ['required', 'string', 'max:100']
        ]);

        $validated['skpd_id'] = Auth::user()->skpd->id;

        TabelRpjmd::create($validated);
        save_user_log('Menambahkan menu treeview RPJMD');

        return back()->with('alert-success', 'Berhasil menambahkan data');
    }

    public function edit($id)
    {
        $tabelRpjmd = TabelRpjmd::findOrFail($id);
        $categories = TabelRpjmd::with('parent')->get();

        return view('admin.treeview.rpjmd_edit', compact('categories', 'tabelRpjmd'));
    }

    public function update(Request $request, $id)
    {
        $tabelRpjmd = TabelRpjmd::findOrFail($id);

        $validated = $this->validate($request, [
            'parent_id' =>  ['required', 'numeric', 'exists:tabel_rpjmd,id'],
            'nama_menu' => ['required', 'string',  'max:100']
        ]);

        $tabelRpjmd->update($validated);
        save_user_log('Mengubah menu treeview RPJMD');

        return back()->with('alert-success', 'Menu treeview RPJMD berhasil diupdate');
    }

    public function destroy($id)
    {
        $tabelRpjmd = TabelRpjmd::findOrFail($id);
        $tabelRpjmd->delete();
        save_user_log('Menghapus menu treeview RPJMD');

        return back()->with('alert-success', 'Menu treeview RPJMD berhasil dihapus');
    }
}
