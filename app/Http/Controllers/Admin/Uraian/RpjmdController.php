<?php

namespace App\Http\Controllers\Admin\Uraian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TabelRpjmd;
use App\Models\UraianRpjmd;
use Illuminate\Support\Facades\Auth;

class RpjmdController extends Controller
{

    public function index(TabelRpjmd $table = null)
    {
        $categories = TabelRpjmd::with(['childs.childs.childs'])->get();
        $title = 'Uraian Form Menu RPJMD';
        $crudRoutePart = 'rpjmd';

        if (is_null($table)) {
            return view('admin.uraian.index', compact('categories', 'title', 'crudRoutePart'));
        }

        $uraian = UraianRpjmd::with('childs')
            ->where('tabel_rpjmd_id', $table->id)
            ->whereNull('parent_id')
            ->orderBy('id')
            ->get();

        return view('admin.uraian.create', compact('table', 'categories', 'title', 'crudRoutePart', 'uraian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'parent_id' => ['nullable', 'numeric'],
            'uraian' => ['required', 'string'],
            'table_id' => ['required', 'numeric', 'exists:tabel_rpjmd,id'],
        ]);

        UraianRpjmd::create([
            'parent_id' => $request->parent_id,
            'uraian' => $request->uraian,
            'skpd_id' => auth()->user()->skpd_id,
            'tabel_rpjmd_id' => $request->table_id,
        ]);

        return back();
    }

    public function edit(TabelRpjmd $table, UraianRpjmd $uraian)
    {
        $categories = TabelRpjmd::where('skpd_id', auth()->user()->skpd_id)->get();
        $uraians = UraianRpjmd::with('childs')
            ->where('tabel_rpjmd_id', $table->id)
            ->whereNull('parent_id')
            ->orderBy('id')
            ->get();
        $title = 'Uraian Form Menu RPJMD';
        $crudRoutePart = 'rpjmd';

        return view('admin.uraian.edit', compact('table', 'uraian', 'categories', 'uraians', 'title', 'crudRoutePart'));
    }

    public function update(Request $request, UraianRpjmd $uraian)
    {
        $request->validate([
            'parent_id' => ['nullable', 'numeric'],
            'uraian' => ['required', 'string', 'max:200'],
        ]);

        $uraian->update($request->all());

        return back();
    }

    public function destroy(Request $request, UraianRpjmd $uraian)
    {
        $uraian->delete();

        return back();
    }
}
