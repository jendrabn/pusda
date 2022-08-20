<?php

namespace App\Http\Controllers\Admin\Uraian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TabelIndikator;
use App\Models\UraianIndikator;

class IndikatorController extends Controller
{
    public function index(TabelIndikator $table = null)
    {
        $categories = TabelIndikator::with(['childs.childs.childs'])->get();
        $title = 'Uraian Form Menu Indikator';
        $crudRoutePart = 'indikator';

        if (is_null($table)) {
            return view('admin.uraian.index', compact('categories', 'title', 'crudRoutePart'));
        }

        $uraian = UraianIndikator::with('childs')
            ->where('tabel_indikator_id', $table->id)
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
            'table_id' => ['required', 'numeric', 'exists:tabel_indikator,id'],
        ]);

        UraianIndikator::create([
            'parent_id' => $request->parent_id,
            'uraian' => $request->uraian,
            'tabel_indikator_id' => $request->table_id,
        ]);

        return back();
    }

    public function edit(TabelIndikator $table, UraianIndikator $uraian)
    {
        $categories = TabelIndikator::all();
        $uraians = UraianIndikator::with('childs')
            ->where('tabel_indikator_id', $table->id)
            ->whereNull('parent_id')
            ->orderBy('id')
            ->get();
        $title = 'Uraian Form Menu Indikator';
        $crudRoutePart = 'indikator';

        return view('admin.uraian.indikator_edit', compact('table', 'uraian', 'categories', 'uraians', 'title', 'crudRoutePart'));
    }

    public function update(Request $request, UraianIndikator $uraian)
    {
        $request->validate([
            'parent_id' => ['nullable', 'numeric'],
            'uraian' => ['required', 'string'],
        ]);

        $uraian->update($request->all());

        return back();
    }

    public function destroy(UraianIndikator $uraian)
    {
        $uraian->delete();

        return back();
    }
}
