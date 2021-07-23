<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileIndikator;
use App\Models\FiturIndikator;
use App\Models\IsiIndikator;
use App\Models\TabelIndikator;
use App\Models\UraianIndikator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IndikatorController extends Controller
{

    public function index(TabelIndikator $tabelIndikator = null)
    {
        $categories = TabelIndikator::all();

        if (is_null($tabelIndikator)) {
            return view('admin.isiuraian.indikator.index', compact('categories'));
        }

        $uraianIndikator = UraianIndikator::getUraianByTableId($tabelIndikator->id);
        $fiturIndikator = FiturIndikator::getFiturByTableId($tabelIndikator->id);
        $files = FileIndikator::where('tabel_indikator_id', $tabelIndikator->id)->get();
        $years = IsiIndikator::getYears();

        return view('admin.isiuraian.indikator.create', compact('tabelIndikator', 'categories', 'uraianIndikator',  'fiturIndikator', 'files', 'years'));
    }

    public function edit(Request $request, UraianIndikator $uraianIndikator)
    {
        abort_if(!$request->ajax(), 404);

        $isiIndikator = $uraianIndikator->isiIndikator()
            ->orderByDesc('tahun')
            ->groupBy('tahun')->take(5)
            ->get(['tahun', 'isi']);

        $response = [
            'uraian_id' => $uraianIndikator->id,
            'uraian_parent_id' => $uraianIndikator->parent_id,
            'uraian' => $uraianIndikator->uraian,
            'satuan' => $uraianIndikator->satuan,
            'isi' =>  $isiIndikator,
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

        $uraianIndikator = UraianIndikator::findOrFail($request->uraian_id);
        $uraianIndikator->uraian = $request->uraian;
        $uraianIndikator->satuan = $request->satuan;
        $uraianIndikator->save();

        $isiIndikator = IsiIndikator::where('uraian_indikator_id', $request->uraian_id)
            ->take(5)
            ->get()
            ->sortBy('tahun');

        $n = 1;
        foreach ($isiIndikator as $value) {
            $push = IsiIndikator::findOrFail($value->id);
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

    public function destroy(UraianIndikator $uraianIndikator)
    {
        $uraianIndikator->delete();
        return back()->with('alert-success', 'Isi uraian berhasil dihapus');
    }

    public function updateFitur(Request $request, FiturIndikator $fiturIndikator)
    {
        $validated = $this->validate($request, [
            'deskripsi' => ['nullable', 'string'],
            'analisis'  => ['nullable', 'string'],
            'permasalahan'  => ['nullable', 'string'],
            'solusi'  => ['nullable', 'string'],
            'saran'  => ['nullable', 'string']
        ]);

        $fiturIndikator->update($validated);

        return back()->with('alert-success', 'Fitur berhasil diupdate');
    }

    public function storeFile(Request $request, TabelIndikator $tabelIndikator)
    {
        $request->validate([
            'file_document' => ['required', 'max:10000', 'mimes:pdf,doc,docx,xlsx,xls,csv'],
        ]);

        $file = $request->file('file_document');
        $fileName = (FileIndikator::latest()->first()->id ?? '') . $file->getClientOriginalName();
        $file->storeAs('file_pusda', $fileName, 'public');

        FileIndikator::create([
            'tabel_indikator_id' => $tabelIndikator->id,
            'file_name' =>  $fileName
        ]);

        return back()->with('alert-success', 'File pendukung berhasil diupload');
    }

    public function destroyFile(FileIndikator $fileIndikator)
    {
        Storage::delete('public/file_pusda/' . $fileIndikator->file_name);
        $fileIndikator->delete();

        return back()->with('alert-success', 'File pendukung berhasil dihapus');
    }

    public function downloadFile(FileIndikator $fileIndikator)
    {
        return Storage::download('public/file_pusda/' . $fileIndikator->file_name);
    }
}
