<?php

namespace App\Http\Controllers\Admin\Uraian;

use App\Events\UserLogged;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skpd;
use App\Models\TabelBps;
use App\Models\UraianBps;

class BpsController extends Controller
{

    public function index(TabelBps $tabelBps = null)
    {
        if (empty($tabelBps)) {
            $categories = TabelBps::all();

            return view('admin.uraian.bps', compact('categories'));
        } else {
            $categories = TabelBps::all();
            $uraian = UraianBps::with('childs')
                ->where('tabel_bps_id', $tabelBps->id)
                ->whereNull('parent_id')
                ->orderBy('id')
                ->get();

            return view('admin.uraian.bps-create', compact('categories', 'uraian', 'tabelBps'));
        }
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'parent_id' => ['nullable', 'numeric'],
            'uraian' => ['required', 'string', 'max:200'],
            'tabel_bps_id' => ['required', 'numeric', 'exists:tabel_bps,id'],
        ]);

        UraianBps::create($validated);
        event(new UserLogged($request->user(), "Menambah data baru pada uraian BPS"));
        return back()->with('alert-success', 'Berhasil menambahkan data');
    }

    public function edit(TabelBps $tabelBps, UraianBps $uraianBps)
    {
        $categories = TabelBps::all();

        $uraian = UraianBps::with('childs')->where('tabel_Bps_id', $tabelBps->id)->whereNull('parent_id')->orderBy('id')->get();

        return view('admin.uraian.bps-edit', compact('categories', 'uraian', 'tabelBps', 'uraianBps'));
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
        $uraianBps->uraian = $request->uraian;
        event(new UserLogged($request->user(), "Mengubah data pada uraian <i>{$uraianBps->uraian}</i> BPS"));
        return back()->with('alert-success', 'Data berhasil diupdate');
    }

    public function destroy(Request $request, UraianBps $uraianBps)
    {
        $uraianBps->delete();
        event(new UserLogged($request->user(), "Menghapus data uraian <i>{$uraianBps->uraian}</i>  pada BPS"));
        return back()->with('alert-success', 'Data berhasil dihapus');
    }
}
