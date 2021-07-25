<?php

namespace App\Http\Controllers\Admin\Uraian;

use App\Events\UserLogged;
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

        if (empty($tabelRpjmd)) {
            $categories = TabelRpjmd::all();

            return view('admin.uraian.rpjmd', compact('skpd', 'categories'));
        } else {
            $categories = TabelRpjmd::all();
            $uraian = UraianRpjmd::with('childs')
                ->where('tabel_rpjmd_id', $tabelRpjmd->id)
                ->whereNull('parent_id')
                ->orderBy('id')
                ->get();

            return view('admin.uraian.rpjmd-create', compact('categories', 'uraian', 'tabelRpjmd', 'skpd'));
        }
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
        event(new UserLogged($request->user(), "Menambah data baru pada uraian RPJMD"));
        return back()->with('alert-success', 'Berhasil menambahkan data');
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

        return view('admin.uraian.rpjmd-edit', compact('categories', 'uraian', 'skpd', 'tabelRpjmd', 'uraianRpjmd'));
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
        $uraianRpjmd->uraian = $request->uraian;
        event(new UserLogged($request->user(), "Mengubah data pada uraian <i>{$uraianRpjmd->uraian}</i> RPJMD"));
        return back()->with('alert-success', 'Data berhasil diupdate');
    }

    public function destroy(Request $request, UraianRpjmd $uraianRpjmd)
    {
        $uraianRpjmd->delete();
        event(new UserLogged($request->user(), "Menghapus data uraian <i>{$uraianRpjmd->uraian}</i>  pada RPJMD"));
        return back()->with('alert-success', 'Data berhasil dihapus');
    }
}
