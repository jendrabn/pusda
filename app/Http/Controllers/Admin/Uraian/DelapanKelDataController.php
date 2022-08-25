<?php

namespace App\Http\Controllers\Admin\Uraian;

use App\Http\Controllers\Controller;
use App\Models\Tabel8KelData;
use App\Models\Uraian8KelData;
use Illuminate\Http\Request;

class DelapanKelDataController extends Controller
{
    public function index(Tabel8KelData $table = null)
    {
        $uraian = null;

        $categories = Tabel8KelData::with(['childs.childs.childs'])->get();
        $title = 'Uraian Form Menu 8 Kelompok Data';
        $crudRoutePart = 'delapankeldata';

        if ($table) {
            $uraian = Uraian8KelData::with('childs')
                ->where('tabel_8keldata_id', $table->id)
                ->whereNull('parent_id')
                ->orderBy('id')
                ->get();
        }

        return view('admin.uraian.index', compact('table', 'categories', 'title', 'crudRoutePart', 'uraian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'parent_id' => ['nullable', 'numeric'],
            'uraian' => ['required', 'string'],
            'table_id' => ['required', 'numeric', 'exists:tabel_8keldata,id'],
        ]);

        Uraian8KelData::create([
            'parent_id' => $request->parent_id,
            'uraian' => $request->uraian,
            'skpd_id' => auth()->user()->skpd_id,
            'tabel_8keldata_id' => $request->table_id
        ]);

        return back();
    }

    public function edit(Tabel8KelData $table, Uraian8KelData $uraian)
    {
        $categories = Tabel8KelData::all();
        $uraians = Uraian8KelData::with('childs')
            ->where('tabel_8keldata_id', $table->id)
            ->whereNull('parent_id')
            ->orderBy('id')
            ->get();
        $title = 'Uraian Form Menu 8 Kelompok Data';
        $crudRoutePart = 'delapankeldata';

        return view('admin.uraian.edit', compact('table', 'uraian', 'categories',  'uraians',  'title', 'crudRoutePart'));
    }

    public function update(Request $request, Uraian8KelData $uraian)
    {
        $request->validate([
            'parent_id' => ['nullable', 'numeric'],
            'uraian' => ['required', 'string'],
        ]);

        $uraian->update($request->all());

        return back();
    }

    public function destroy(Uraian8KelData $uraian)
    {
        $uraian->delete();

        return back();
    }
}
