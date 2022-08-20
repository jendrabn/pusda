<?php

namespace App\Http\Controllers\Admin\Uraian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TabelBps;
use App\Models\UraianBps;

class BpsController extends Controller
{

    public function index(TabelBps $table = null)
    {
        $categories = TabelBps::with(['childs.childs.childs'])->get();
        $title = 'Uraian Form Menu BPS';
        $crudRoutePart = 'bps';

        if (is_null($table)) {
            return view('admin.uraian.index', compact('categories', 'title', 'crudRoutePart'));
        }

        $uraian = UraianBps::with('childs')
            ->where('tabel_bps_id', $table->id)
            ->whereNull('parent_id')
            ->orderBy('id')
            ->get();

        return view('admin.uraian.create', compact('table', 'categories', 'title', 'crudRoutePart', 'uraian',));
    }

    public function store(Request $request)
    {
        $request->validate([
            'parent_id' => ['nullable', 'numeric'],
            'uraian' => ['required', 'string'],
            'table_id' => ['required', 'numeric', 'exists:tabel_bps,id'],
        ]);

        UraianBps::create([
            'parent_id' => $request->parent_id,
            'uraian' => $request->uraian,
            'tabel_bps_id' => $request->table_id,
        ]);

        return back();
    }

    public function edit(TabelBps $table, UraianBps $uraian)
    {
        $categories = TabelBps::all();
        $uraians = UraianBps::with('childs')
            ->where('tabel_Bps_id', $table->id)
            ->whereNull('parent_id')
            ->orderBy('id')
            ->get();
        $title = 'Uraian Form Menu BPS';
        $crudRoutePart = 'bps';

        return view('admin.uraian.edit', compact('table', 'uraian', 'categories', 'uraians', 'title', 'crudRoutePart'));
    }

    public function update(Request $request, UraianBps $uraian)
    {
        $request->validate([
            'parent_id' => ['nullable', 'numeric'],
            'uraian' => ['required', 'string'],
        ]);

        $uraian->update($request->all());

        return back();
    }

    public function destroy(UraianBps $uraian)
    {
        $uraian->delete();

        return back();
    }
}
