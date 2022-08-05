<?php

namespace App\Http\Controllers\Admin\Uraian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TabelBps;
use App\Models\UraianBps;

class BpsController extends Controller
{

    public function index(TabelBps $tabelBps = null)
    {
        $categories = TabelBps::with(['childs.childs.childs'])->get();

        if ($tabelBps) {
            $uraian = UraianBps::with('childs')
                ->where('tabel_bps_id', $tabelBps->id)
                ->whereNull('parent_id')
                ->orderBy('id')
                ->get();

            return view('admin.uraian.bps_create', compact('categories', 'uraian', 'tabelBps'));
        }

        return view('admin.uraian.bps', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'parent_id' => ['nullable', 'numeric'],
            'uraian' => ['required', 'string', 'max:200'],
            'tabel_bps_id' => ['required', 'numeric', 'exists:tabel_bps,id'],
        ]);

        UraianBps::create($validated);

        return back()->with('alert-success', 'Berhasil menambahkan form menu uraian BPS');
    }

    public function edit(TabelBps $tabelBps, UraianBps $uraianBps)
    {
        $categories = TabelBps::all();
        $uraian = UraianBps::with('childs')
            ->where('tabel_Bps_id', $tabelBps->id)
            ->whereNull('parent_id')
            ->orderBy('id')
            ->get();

        return view('admin.uraian.bps_edit', compact('categories', 'uraian', 'tabelBps', 'uraianBps'));
    }

    public function update(Request $request, UraianBps $uraianBps)
    {
        $validated = $this->validate($request, [
            'parent_id' => ['nullable', 'numeric'],
            'uraian' => ['required', 'string', 'max:200'],
            'skpd_id' => ['nullable', 'numeric', 'exists:skpd,id'],
            'tabel_Bps_id' => ['required', 'numeric', 'exists:tabel_Bps,id'],
        ]);

        $uraianBps->update($validated);

        return back()->with('alert-success', 'Form menu uraian BPS berhasil diupdate');
    }

    public function destroy(UraianBps $uraianBps)
    {
        $uraianBps->delete();

        return back()->with('alert-success', 'Form menu uraian BPS berhasil dihapus');
    }
}
