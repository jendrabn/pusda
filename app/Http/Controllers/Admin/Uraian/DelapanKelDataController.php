<?php

namespace App\Http\Controllers\Admin\Uraian;

use App\Events\UserLogged;
use App\Http\Controllers\Controller;
use App\Models\Tabel8KelData;
use App\Models\Uraian8KelData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DelapanKelDataController extends Controller
{
    public function index(Tabel8KelData $tabel8KelData = null)
    {
        $skpd =  Auth::user()->skpd;

        if (empty($tabel8KelData)) {
            $categories = Tabel8KelData::all();

            return view('admin.uraian.delapankeldata', compact('skpd', 'categories'));
        } else {
            $categories = Tabel8KelData::all();
            $uraian = Uraian8KelData::with('childs')
                ->where('tabel_8keldata_id', $tabel8KelData->id)
                ->whereNull('parent_id')
                ->orderBy('id')
                ->get();

            return view('admin.uraian.delapankeldata-create', compact('categories', 'uraian', 'tabel8KelData', 'skpd'));
        }
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'parent_id' => ['nullable', 'numeric'],
            'uraian' => ['required', 'string', 'max:200'],
            'skpd_id' => ['nullable', 'numeric', 'exists:skpd,id'],
            'tabel_8keldata_id' => ['required', 'numeric', 'exists:tabel_8keldata,id'],
        ]);

        Uraian8KelData::create($validated);
        event(new UserLogged($request->user(), "Menambah data baru pada uraian 8 Kelompok Data"));
        return back()->with('alert-success', 'Berhasil menambahkan data');
    }

    public function edit(Tabel8KelData $tabel8KelData, Uraian8KelData $uraian8KelData)
    {
        $skpd = Auth::user()->skpd;
        $categories = Tabel8KelData::all();
        $uraian = Uraian8KelData::with('childs')->where('tabel_8keldata_id', $tabel8KelData->id)->whereNull('parent_id')->orderBy('id')->get();

        return view('admin.uraian.delapankeldata-edit', compact('categories', 'uraian', 'skpd', 'tabel8KelData', 'uraian8KelData'));
    }

    public function update(Request $request, Uraian8KelData $uraian8KelData)
    {
        $validated = $this->validate($request, [
            'parent_id' => ['nullable', 'numeric'],
            'uraian' => ['required', 'string', 'max:200'],
            'skpd_id' => ['nullable', 'numeric', 'exists:skpd,id'],
            'tabel_8keldata_id' => ['required', 'numeric', 'exists:tabel_8keldata,id'],
        ]);

        $uraian8KelData->update($validated);
        $uraian8KelData->uraian = $request->uraian;
        event(new UserLogged($request->user(), "Mengubah data pada uraian <i>{$uraian8KelData->uraian}</i> 8 Kelompok Data"));
        return back()->with('alert-success', 'Data berhasil diupdate');
    }

    public function destroy(Request $request, Uraian8KelData $uraian8KelData)
    {
        $uraian8KelData->delete();
        event(new UserLogged($request->user(), "Menghapus data uraian <i>{$uraian8KelData->uraian}</i>  pada 8 Kelompok Data"));
        return back()->with('alert-success', 'Data berhasil dihapus');
    }
}
