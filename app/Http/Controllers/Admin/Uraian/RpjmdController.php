<?php

namespace App\Http\Controllers\Admin\Uraian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TabelRpjmd;
use App\Models\UraianRpjmd;
use Illuminate\Support\Facades\Auth;

class RpjmdController extends Controller
{

    public function index(TabelRpjmd $tabelRpjmd = null)
    {
        $skpd = Auth::user()->skpd;
        $categories = TabelRpjmd::with(['childs.childs.childs'])->get();

        if ($tabelRpjmd) {
            $uraian = UraianRpjmd::with('childs')
                ->where('tabel_rpjmd_id', $tabelRpjmd->id)
                ->whereNull('parent_id')
                ->orderBy('id')
                ->get();

            return view('admin.uraian.rpjmd_create', compact('categories', 'uraian', 'tabelRpjmd', 'skpd'));
        }

        return view('admin.uraian.rpjmd', compact('skpd', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'parent_id' => ['nullable', 'numeric'],
            'uraian' => ['required', 'string', 'max:200'],
            'skpd_id' => ['nullable', 'numeric', 'exists:skpd,id'],
            'tabel_rpjmd_id' => ['required', 'numeric', 'exists:tabel_rpjmd,id'],
        ]);

        UraianRpjmd::create($validated);

        return back()->with('alert-success', 'Berhasil menambahkan form menu uraian RPJMD');
    }

    public function edit(TabelRpjmd $tabelRpjmd, UraianRpjmd $uraianRpjmd)
    {
        $skpd = Auth::user()->skpd;
        $categories = TabelRpjmd::where('skpd_id', $skpd->id)->get();
        $uraian = UraianRpjmd::with('childs')
            ->where('tabel_rpjmd_id', $tabelRpjmd->id)
            ->whereNull('parent_id')
            ->orderBy('id')
            ->get();

        return view('admin.uraian.rpjmd_edit', compact('categories', 'uraian', 'skpd', 'tabelRpjmd', 'uraianRpjmd'));
    }

    public function update(Request $request, UraianRpjmd $uraianRpjmd)
    {
        $validated = $this->validate($request, [
            'parent_id' => ['nullable', 'numeric'],
            'uraian' => ['required', 'string', 'max:200'],
            'skpd_id' => ['nullable', 'numeric', 'exists:skpd,id'],
            'tabel_rpjmd_id' => ['required', 'numeric', 'exists:tabel_Rpjmd,id'],
        ]);

        $uraianRpjmd->update($validated);

        return back()->with('alert-success', 'Form menu uraian RPJMD berhasil diupdate');
    }

    public function destroy(Request $request, UraianRpjmd $uraianRpjmd)
    {
        $uraianRpjmd->delete();

        return back()->with('alert-success', 'Form menu uraian RPJMD berhasil dihapus');
    }
}
