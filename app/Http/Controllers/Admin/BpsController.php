<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileBps;
use App\Models\FiturBps;
use App\Models\IsiBps;
use App\Models\TabelBps;
use App\Models\UraianBps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BpsController extends Controller
{
    public function index(TabelBps $tabelBps = null)
    {
        $categories = TabelBps::all();

        if (is_null($tabelBps)) {
            return view('admin.isiuraian.bps.index', compact('categories'));
        }

        $uraianBps = UraianBps::getUraianByTableId($tabelBps->id);
        $fiturBps = FiturBps::getFiturByTableId($tabelBps->id);
        $files = FileBps::where('tabel_bps_id', $tabelBps->id)->get();
        $years = IsiBps::getYears();

        return view('admin.isiuraian.bps.create', compact('tabelBps', 'categories', 'uraianBps',  'fiturBps', 'files', 'years'));
    }

    public function edit(Request $request, UraianBps $uraianBps)
    {
        abort_if(!$request->ajax(), 404);

        $isiBps = $uraianBps->isiBps()
            ->orderByDesc('tahun')
            ->groupBy('tahun')
            ->take(5)
            ->get(['tahun', 'isi']);

        $response = [
            'uraian_id' => $uraianBps->id,
            'uraian_parent_id' => $uraianBps->parent_id,
            'uraian' => $uraianBps->uraian,
            'satuan' => $uraianBps->satuan,
            'isi' =>  $isiBps,
        ];

        return response()->json($response);
    }

    public function update(Request $request)
    {
        $request->validate([
            'uraian' => ['required', 'string'],
            'satuan' => ['required', 'string'],
            't1' => ['required', 'numeric'],
            't2' => ['required', 'numeric'],
            't3' => ['required', 'numeric'],
            't4' => ['required', 'numeric'],
            't5' => ['required', 'numeric'],
        ]);

        $uraianBps = UraianBps::findOrFail($request->uraian_id);
        $uraianBps->uraian = $request->uraian;
        $uraianBps->satuan = $request->satuan;
        $uraianBps->save();

        $isiBps = IsiBps::where('uraian_bps_id', $request->uraian_id)
            ->take(5)
            ->get()
            ->sortBy('tahun');

        $n = 1;
        foreach ($isiBps as $value) {
            $push = IsiBps::findOrFail($value->id);
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

    public function destroy(UraianBps $uraianBps)
    {
        $uraianBps->delete();
        return back()->with('alert-success', 'Isi uraian berhasil dihapus');
    }

    public function updateFitur(Request $request, FiturBps $fiturBps)
    {
        $validated = $this->validate($request, [
            'deskripsi' => ['nullable', 'string'],
            'analisis'  => ['nullable', 'string'],
            'permasalahan'  => ['nullable', 'string'],
            'solusi'  => ['nullable', 'string'],
            'saran'  => ['nullable', 'string']
        ]);

        $fiturBps->update($validated);

        return back()->with('alert-success', 'Fitur berhasil diupdate');
    }


    public function storeFile(Request $request, TabelBps $tabelBps)
    {
        $request->validate([
            'file_document' => ['required', 'max:10000', 'mimes:pdf,doc,docx,xlsx,xls,csv'],
        ]);

        $file = $request->file('file_document');
        $fileName = (FileBps::latest()->first()->id ?? '') . $file->getClientOriginalName();
        $file->storeAs('file_pusda', $fileName, 'public');

        FileBps::create([
            'tabel_bps_id' => $tabelBps->id,
            'file_name' =>  $fileName
        ]);

        return back()->with('alert-success', 'File pendukung berhasil diupload');
    }

    public function destroyFile(FileBps $fileBps)
    {
        Storage::delete('public/file_pusda/' . $fileBps->file_name);
        $fileBps->delete();

        return back()->with('alert-success', 'File pendukung berhasil dihapus');
    }

    public function downloadFile(FileBps $fileBps)
    {
        return Storage::download('public/file_pusda/' . $fileBps->file_name);
    }
}
