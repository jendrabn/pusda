<?php

namespace App\Http\Controllers\Skpd;

use App\Exports\RpjmdExport;
use App\Http\Controllers\Controller;
use App\Models\FileRpjmd;
use App\Models\FiturRpjmd;
use App\Models\IsiRpjmd;
use App\Models\Skpd;
use App\Models\TabelRpjmd;
use App\Models\UraianRpjmd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class RpjmdController extends Controller
{
    public function index(TabelRpjmd $tabelRpjmd = null)
    {
        $skpd = Auth::user()->skpd;
        $categories = TabelRpjmd::all();
        $tabelRpjmdIds = UraianRpjmd::select('tabel_rpjmd_id as id')
            ->where('skpd_id', $skpd->id)
            ->groupBy('tabel_rpjmd_id')
            ->get();

        if (is_null($tabelRpjmd)) {
            return view('skpd.isiuraian.rpjmd.index', compact('skpd', 'tabelRpjmdIds', 'categories'));
        }

        $uraianRpjmd = UraianRpjmd::getUraianByTableId($tabelRpjmd->id);
        $fiturRpjmd = FiturRpjmd::getFiturByTableId($tabelRpjmd->id);
        $files = FileRpjmd::where('tabel_rpjmd_id', $tabelRpjmd->id)->get();
        $years = IsiRpjmd::getYears();
        $allSkpd = Skpd::all()->pluck('singkatan', 'id');

        return view('skpd.isiuraian.rpjmd.create', compact('tabelRpjmdIds', 'allSkpd', 'tabelRpjmd', 'skpd', 'categories', 'uraianRpjmd',  'fiturRpjmd', 'files', 'years'));
    }

    public function edit(Request $request, UraianRpjmd $uraianRpjmd)
    {
        abort_if(!$request->ajax(), 404);

        $isiRpjmd = $uraianRpjmd->isiRpjmd()->orderByDesc('tahun')->groupBy('tahun')->take(5)->get(['tahun', 'isi']);

        $response = [
            'uraian_id' => $uraianRpjmd->id,
            'uraian_parent_id' => $uraianRpjmd->parent_id,
            'uraian' => $uraianRpjmd->uraian,
            'satuan' => $uraianRpjmd->satuan,
            'ketersediaan_data' => $uraianRpjmd->ketersediaan_data,
            'isi' =>  $isiRpjmd,
        ];

        return response()->json($response);
    }

    public function update(Request $request)
    {
        $request->validate([
            'uraian' => ['required', 'string'],
            'satuan' => ['required', 'string'],
        ]);

        $uraianRpjmd = UraianRpjmd::findOrFail($request->uraian_id);
        $uraianRpjmd->uraian = $request->uraian;
        $uraianRpjmd->satuan = $request->satuan;
        $uraianRpjmd->save();

        $isiRpjmd = IsiRpjmd::where('uraian_rpjmd_id', $request->uraian_id)->take(5)->get()->sortBy('tahun');

        $n = 1;
        foreach ($isiRpjmd as  $value) {
            $push = IsiRpjmd::findOrFail($value->id);
            if ($n == 1) {
                $push->isi = $request->t1;
            } else if ($n == 2) {
                $push->isi = $request->t2;
            } else if ($n == 3) {
                $push->isi = $request->t3;
            } else if ($n == 4) {
                $push->isi = $request->t4;
            } else {
                $push->isi = $request->t5;
            }
            $push->save();
            $n++;
        }

        return back()->with('alert-success', 'Isi uraian berhasil diupdate');
    }

    public function destroy(UraianRpjmd $uraianRpjmd)
    {
        $uraianRpjmd->delete();
        return back()->with('alert-success', 'Isi uraian berhasil dihapus');
    }


    public function updateFitur(Request $request, FiturRpjmd $fiturRpjmd)
    {
        $validated =  $this->validate($request, [
            'deskripsi' => ['nullable', 'string'],
            'analisis'  => ['nullable', 'string'],
            'permasalahan'  => ['nullable', 'string'],
            'solusi'  => ['nullable', 'string'],
            'saran'  => ['nullable', 'string']
        ]);

        $fiturRpjmd->update($validated);

        return back()->with('alert-success', 'Fitur berhasil diupdate');
    }

    public function storeFile(Request $request, TabelRpjmd $tabelRpjmd)
    {
        $request->validate([
            'file_document' => ['required', 'max:10000', 'mimes:pdf,doc,docx,xlsx,xls,csv'],
        ]);

        $file = $request->file('file_document');
        $fileName = (FileRpjmd::latest()->first()->id ?? '') . $file->getClientOriginalName();
        $file->storeAs('file_pusda', $fileName, 'public');

        FileRpjmd::create([
            'tabel_rpjmd_id' => $tabelRpjmd->id,
            'file_name' =>  $fileName
        ]);

        return back()->with('alert-success', 'File uploaded');
    }

    public function destroyFile(FileRpjmd $fileRpjmd)
    {
        Storage::delete('public/file_pusda/' . $fileRpjmd->file_name);
        $fileRpjmd->delete();

        return back()->with('alert-success', 'File deleted');
    }

    public function downloadFile(FileRpjmd $fileRpjmd)
    {
        return Storage::download('public/file_pusda/' . $fileRpjmd->file_name);
    }
}
